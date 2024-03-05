<?php

declare(strict_types=1);

namespace App\Domain\PostalCode;

use JsonSerializable;

class PostalCode implements JsonSerializable
{
    public function __construct(
        private readonly string   $post_code,
        private readonly string   $postal_code,
        private readonly string   $region,
        private readonly ?string  $district_old = null,
        private readonly ?string  $district_new = null,
        private readonly ?string  $settlement = null,
        private readonly ?string  $region_eng = null,
        private readonly ?string  $district_new_eng = null,
        private readonly ?string  $settlement_eng = null,
        private readonly ?string  $post_office = null,
        private readonly ?string  $post_office_eng = null,
        private readonly int|bool $is_imported = false,
    )
    {

    }

    public function getPostCode(): string
    {
        return $this->post_code;
    }

    public function getPostalCode(): string
    {
        return $this->postal_code;
    }

    public function getRegion(): string
    {
        return $this->region;
    }

    public function getDistrictOld(): ?string
    {
        return $this->district_old;
    }

    public function getDistrictNew(): ?string
    {
        return $this->district_new;
    }

    public function getSettlement(): ?string
    {
        return $this->settlement;
    }

    public function getRegionEng(): ?string
    {
        return $this->region_eng;
    }

    public function getDistrictNewEng(): ?string
    {
        return $this->district_new_eng;
    }

    public function getSettlementEng(): ?string
    {
        return $this->settlement_eng;
    }

    public function getPostOffice(): ?string
    {
        return $this->post_office;
    }

    public function getPostOfficeEng(): ?string
    {
        return $this->post_office_eng;
    }

    public function getIsImported(): bool
    {
        if (is_bool($this->is_imported)) {
            return $this->is_imported;
        }

        return $this->is_imported === 1;
    }

    public function jsonSerialize(): array
    {
        return [
            'region' => $this->getRegion(),
            'district_old' => $this->getDistrictOld(),
            'district_new' => $this->getDistrictNew(),
            'settlement' => $this->getSettlement(),
            'post_code' => $this->getPostCode(),
            'postal_code' => $this->getPostalCode(),
            'region_eng' => $this->getRegionEng(),
            'district_new_eng' => $this->getDistrictNewEng(),
            'settlement_eng' => $this->getSettlementEng(),
            'post_office' => $this->getPostOffice(),
            'post_office_eng' => $this->getPostOfficeEng(),
            'is_imported' => $this->getIsImported(),
        ];
    }
}
