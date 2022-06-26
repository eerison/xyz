<?php

declare(strict_types=1);

use function Eerison\PestPluginApiPlatform\get;

it('is returning the expect fields from product.')
    ->get('/api/products', ['headers' => ['Accept' => 'application/json']])
    ->assertResponseIsSuccessful()
    ->expectResponseContent()
    ->json()
    ->each(
        fn ($product) => $product
            ->id->toBeNumeric()
            ->name->toBeString()
            ->brandName->toBeString()
            ->descriptionText->toBeString()
            ->articles->toBeArray()
            ->articles->toBeGreaterThan(0)
            ->articles->each(
                fn($article) => $article
                    ->id->toBeNumeric()
                    ->shortDescription->toBeString()
                    ->price->toBeFloat()
                    ->unit->toBeString()
                    ->pricePerUnitText->toBeString()
                    ->image->toBeString()
        )
    )
;

it('will filter products by article price.')
    ->get('/api/products?articles.price=17.99', ['headers' => ['Accept' => 'application/json']])
    ->assertResponseIsSuccessful()
    ->expectResponseContent()
    ->json()
    ->sequence(
        fn ($product) => $product
            ->articles->each(
                fn($article) => $article
                    ->price->toBe(17.99))
    )
;

it('is ordering fields', function (string $filter, string $value, string $productName) {
    $response = get(
        sprintf('/api/products?%s=%s&itemsPerPage=1', $filter, $value),
        ['headers' => ['Accept' => 'application/json']]
    );

    expect($response->getContent())
        ->json()
        ->sequence(fn ($product) => $product->name->toBe($productName));
})->with([
        ['order[articles.price]', 'desc', 'highest_product'],
        ['order[articles.price]', 'asc', 'lowest_product'],
        ['order[articles.pricePerUnit]', 'desc', 'highest_price_per_unit_product'],
        ['order[articles.pricePerUnit]', 'asc', 'lowest_price_per_unit_product'],
    ]);

