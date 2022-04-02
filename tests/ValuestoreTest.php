<?php

use Bvtterfly\Valuestore\Codecs\Yaml;
use Bvtterfly\Valuestore\Exceptions\DecodeException;
use Bvtterfly\Valuestore\Exceptions\UnknownCodecException;
use Bvtterfly\Valuestore\Valuestore;
use Illuminate\Support\Facades\Storage;

it('should throw an exception if yaml file is invalid', function () {
    Storage::fake('test');
    config()->set('valuestore.disk', 'test');
    Storage::disk('test')->put('settings.yaml', 'test: 0 : \'1\'');
    (Valuestore::make('settings.yaml'))->all();
})->expectException(DecodeException::class);

it('should throw an exception if json file is invalid', function () {
    Storage::fake('test');
    config()->set('valuestore.disk', 'test');
    Storage::disk('test')->put('settings.json', 'test: 0 : \'1\'');
    (Valuestore::make('settings.json'))->all();
})->expectException(DecodeException::class);

it('should throw an exception if file type isn\'t a supported type', function () {
    Storage::fake('test');
    config()->set('valuestore.disk', 'test');
    Valuestore::make('settings.xss');
})->expectException(UnknownCodecException::class);

it('can store some values to json format on filesystem', function () {
    Storage::fake('test');
    config()->set('valuestore.disk', 'test');
    $settings = ['__KEY__' => '__VALUE__'];
    Valuestore::make('settings.json', $settings);
    Storage::disk('test')->assertExists('settings.json');
    $fileContent = Storage::disk('test')->get('settings.json');
    expect(json_decode($fileContent, true))->toBe($settings);
});

it('can store some values to yaml format on filesystem', function () {
    Storage::fake('test');
    config()->set('valuestore.disk', 'test');
    $settings = ['__KEY__' => '__VALUE__'];
    Valuestore::make('settings.yaml', $settings);
    Storage::disk('test')->assertExists('settings.yaml');
    $fileContent = Storage::disk('test')->get('settings.yaml');
    expect((new Yaml())->decode($fileContent))->toBe($settings);
});

it('can get a value from filesystem', function () {
    Storage::fake('test');
    config()->set('valuestore.disk', 'test');
    $settings = ['__KEY__' => '__VALUE__'];
    $valuestore = Valuestore::make('settings.json', $settings);
    expect($valuestore['__KEY__'])->toBe('__VALUE__');
    expect($valuestore->all())->toBe($settings);
    $settings = ['__KEY2__' => '__VALUE2__'];
    $valuestore = Valuestore::make('settings.yaml', $settings);
    expect($valuestore['__KEY2__'])->toBe('__VALUE2__');
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
