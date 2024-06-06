<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class ListingDTOData extends Data
{
  public function __construct(
    public string $title,
    public string $company,
    public string $location,
    public string $website,
    public string $email,
    public string $tags,
    public ?string $logo = null,
    public ?string $salary = null,
    public ?string $deadline = null,
    public string $description,
    public string $requirements,
  ) {
  }
}
