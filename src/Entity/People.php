<?php

declare(strict_types=1);

namespace Entity;

class People
{
    private int $id;
    private ?int $avatarId;
    private ?string $birthsday;
    private ?string $deathday;
    private string $name;
    private ?string $biography;
    private ?string $placeOfBirth;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return People
     */
    public function setId(int $id): People
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getAvatarId(): ?int
    {
        return $this->avatarId;
    }

    /**
     * @param int|null $avatarId
     * @return People
     */
    public function setAvatarId(?int $avatarId): People
    {
        $this->avatarId = $avatarId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBirthsday(): ?string
    {
        return $this->birthsday;
    }

    /**
     * @param string|null $birthsday
     * @return People
     */
    public function setBirthsday(?string $birthsday): People
    {
        $this->birthsday = $birthsday;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeathday(): ?string
    {
        return $this->deathday;
    }

    /**
     * @param string|null $deathday
     * @return People
     */
    public function setDeathday(?string $deathday): People
    {
        $this->deathday = $deathday;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return People
     */
    public function setName(string $name): People
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBiography(): ?string
    {
        return $this->biography;
    }

    /**
     * @param string|null $biography
     * @return People
     */
    public function setBiography(?string $biography): People
    {
        $this->biography = $biography;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlaceOfBirth(): ?string
    {
        return $this->placeOfBirth;
    }

    /**
     * @param string|null $placeOfBirth
     * @return People
     */
    public function setPlaceOfBirth(?string $placeOfBirth): People
    {
        $this->placeOfBirth = $placeOfBirth;
        return $this;
    }

    public function getRoleByIdMovie($id)
    {
        return Cast::getByIdAndMovie($id, $this->id);
    }



}
