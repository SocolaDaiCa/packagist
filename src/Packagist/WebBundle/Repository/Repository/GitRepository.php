<?php

namespace Packagist\WebBundle\Repository\Repository;

class GitRepository implements RepositoryInterface
{
    protected $owner;
    protected $repository;

    public function __construct($url)
    {
        preg_match('#^(?:https?|git)://github\.com/([^/]+)/(.+?)(?:\.git)?$#', $url, $match);
        $this->owner = $match[1];
        $this->repository = $match[2];
    }

    public function getComposerFile($hash)
    {
        return json_decode(file_get_contents('https://raw.github.com/'.$this->owner.'/'.$this->repository.'/'.$hash.'/composer.json'), true);
    }

    public function getRepoData()
    {
        return json_decode(file_get_contents('http://github.com/api/v2/json/repos/show/'.$this->owner.'/'.$this->repository), true);
    }

    public function getTagsData()
    {
        return json_decode(file_get_contents('http://github.com/api/v2/json/repos/show/'.$this->owner.'/'.$this->repository.'/tags'), true);
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function getRepository()
    {
        return $this->repository;
    }
}