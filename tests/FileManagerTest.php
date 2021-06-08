<?php

namespace Tests;

use Gvera\Exceptions\NotFoundException;
use Gvera\Helpers\config\Config;
use Gvera\Helpers\fileSystem\File;
use Gvera\Helpers\fileSystem\FileManager;
use PHPUnit\Framework\TestCase;

class FileManagerTest extends TestCase
{
    private FileManager $fileManager;

    public function setUp(): void
    {
        $config = new Config();
        $this->fileManager = new FileManager($config);
    }

    /**
     * @test
     * @throws \Gvera\Exceptions\NotFoundException
     */
    public function testFileManager()
    {
        $file = new File();
        $file->setName('newtest.txt');
        $file->setPath(__DIR__."/files/");
        $file->setContent('this is a new test');
        $file->setSize(123)
            ->setTemporaryName('asd')
            ->setType('asd');

        $this->assertTrue($file->getSize() === 123);
        $this->assertTrue($file->getTemporaryName() === 'asd');
        $this->assertTrue($file->getType() === 'asd');
        $this->fileManager->createFile($file);

        $this->assertTrue(file_exists(__DIR__."/files/newtest.txt"));

        $this->fileManager->removeFromFileSystem(__DIR__."/files/newtest.txt");
        $this->assertFalse(file_exists(__DIR__."/files/newtest.txt"));

        $this->fileManager->createDirectory(__DIR__.'/newfiles');
        $tripleTest = new File();
        $tripleTest->setPath(__DIR__.'/newfiles/');
        $tripleTest->setName('tripletest.txt');
        $tripleTest->setContent('triple test');
        $this->fileManager->createFile($tripleTest);

        $this->assertTrue(is_dir(__DIR__."/newfiles"));
        $this->assertTrue(file_exists(__DIR__.'/newfiles/tripletest.txt'));

        $this->fileManager->recursiveRemove(__DIR__.'/newfiles');
        $this->assertTrue(!is_dir(__DIR__."/newfiles"));

        $this->assertNotEmpty($this->fileManager->getFileContents(__DIR__."/files/test.txt"));
    }

    /**
     * @test
     */
    public function testExceptions()
    {
        $this->expectException(NotFoundException::class);
        $this->fileManager->getFileContents(__DIR__."/files/nofile.txt");
    }

    /**
     * @test
     */
    public function testRemoveFileException()
    {
        $this->expectException(NotFoundException::class);
        $this->fileManager->removeFromFileSystem(__DIR__."/files/nofile.txt");
    }

    /**
     * @throws NotFoundException
     * @throws \Gvera\Exceptions\InvalidFileTypeException
     * @test
     */
    public function testFileUploadExceptionsWithoutFile()
    {
        $this->expectException(NotFoundException::class);
        $file = new File();
        $file->setError(3);
        $file->setName('asd.asd');
        $file->setTemporaryName('asd');
        $this->assertTrue($this->fileManager->saveToFileSystem(__DIR__."/files/", $file));
    }

    /**
     * @throws NotFoundException
     * @throws \Gvera\Exceptions\InvalidFileTypeException
     * @test
     */
    public function testFileUploadExceptionsWithErrorFour()
    {
        $file = new File();
        $file->setError(4);
        $file->setName('asd.asd');
        $file->setTemporaryName('asd');
        $this->assertTrue($this->fileManager->saveToFileSystem(__DIR__."/files/", $file));
    }

    /**
     * @test
     */
    public function buildingFilesTest()
    {
        $files = [
            'userfile' => [
                'name'     => "test.png",
                'type'     => 'image/png',
                'tmp_name' => "213dcqqwd.png",
                'size'     => 123,
                'error'    => 4
            ],
        ];

        $this->fileManager->buildFilesFromSource($files);

        $this->assertTrue(is_a($this->fileManager->getByName("userfile"),File::class));

        $this->expectException(NotFoundException::class);
        $this->fileManager->getByName('qpowjq');
    }

    /**
     * @test
     */
    public function buildingFilesWithoutExtensionTest()
    {
        $newfiles = [
            'seconduserfile' => [
                'name'     => "test",
                'type'     => 'image/png',
                'tmp_name' => "213dcqqwd.png",
                'size'     => 123,
                'error'    => 4
            ],
        ];

        $this->fileManager->buildFilesFromSource($newfiles);
        $this->assertTrue(is_a($this->fileManager->getByName("seconduserfile"),File::class));
    }
}