<?php

use Bvtterfly\Valuestore\Valuestore;
use Illuminate\Support\Facades\Storage;

it('can store some values on filesystem', function () {
    Storage::fake('test');
    config()->set('valuestore.disk', 'test');
    $settings = ['__KEY__' => '__VALUE__'];
    Valuestore::make('settings.json', $settings);
    Storage::disk('test')->assertExists('settings.json');
    $fileContent = Storage::disk('test')->get('settings.json');
    expect(json_decode($fileContent, true))->toBe($settings);
});

it('can get a value from filesystem', function () {
    Storage::fake('test');
    config()->set('valuestore.disk', 'test');
    $settings = ['__KEY__' => '__VALUE__'];
    $valuestore = Valuestore::make('settings.json', $settings);
    expect($valuestore['__KEY__'])->toBe('__VALUE__');
    expect($valuestore->all())->toBe($settings);
});

it('can remove a file from filesystem', function () {
    Storage::fake('test');
    config()->set('valuestore.disk', 'test');
    $settings = ['__KEY__' => '__VALUE__'];
    $valuestore = Valuestore::make('settings.json', $settings);
    $valuestore->flush();
    Storage::disk('test')->assertMissing('settings.json');
});
