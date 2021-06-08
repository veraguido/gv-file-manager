<?php

namespace Gvera\Helpers\fileSystem;

class File
{

    private string $name;
    private int $size;
    private string $type;
    private string $temporaryName;
    private int $error;
    private string $path;
    private string $content;

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * Get the value of name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     * @param $name
     * @return  self
     */
    public function setName($name): File
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of size
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * Set the value of size
     *
     * @param $size
     * @return  self
     */
    public function setSize(int $size): File
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get the value of temporaryName
     * @return string
     */
    public function getTemporaryName(): string
    {
        return $this->temporaryName;
    }

    /**
     * Set the value of temporaryName
     *
     * @param $temporaryName
     * @return  self
     */
    public function setTemporaryName($temporaryName): File
    {
        $this->temporaryName = $temporaryName;

        return $this;
    }

    /**
     * Get the value of error
     * @return int
     */
    public function getError(): int
    {
        return $this->error;
    }

    /**
     * Set the value of error
     *
     * @param $error
     * @return  self
     */
    public function setError($error): File
    {
        $this->error = $error;

        return $this;
    }

    /**
     * Get the value of type
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @param $type
     * @return  self
     */
    public function setType($type): File
    {
        $this->type = $type;

        return $this;
    }

    public function setContent(string $content)
    {
        $this->content = $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
