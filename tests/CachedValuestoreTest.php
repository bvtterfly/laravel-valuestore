<?php

use Bvtterfly\Valuestore\CachedValuestore;
use Illuminate\Support\Facades\Storage;

test('values are cached locally for get method', function () {
    Storage::fake('test');
    config()->set('valuestore.disk', 'test');
    $settings = ['__KEY__' => '__VALUE__'];
    $valuestore = CachedValuestore::make('settings.json', $settings);
    expect($valuestore)->toBeInstanceOf(CachedValuestore::class);
    expect($valuestore['__KEY__'])->toBe('__VALUE__');
    expect($valuestore->all())->toBe($settings);
    Storage::disk('test')->delete('settings.json');
    expect($valuestore->get('__KEY__'))->toBe('__VALUE__');
});

test('values are cached locally for has method', function () {
    Storage::fake('test');
    config()->set('valuestore.disk', 'test');
    $settings = ['__KEY__' => '__VALUE__'];
    $valuestore = CachedValuestore::make('settings.json', $settings);
    Storage::disk('test')->delete('settings.json');
    expect($valuestore->has('__KEY__'))->toBeTrue();
    expect($valuestore->has('__KEY2__'))->toBeFalse();
});

test('values are cached locally for all method', function () {
    Storage::fake('test');
    config()->set('valuestore.disk', 'test');
    $settings = ['__KEY__' => '__VALUE__'];
    $valuestore = CachedValuestore::make('settings.json', $settings);
    Storage::disk('test')->delete('settings.json');
    expect($valuestore->all())->toBe($settings);
});

test('values are cached locally for all starting with method', function () {
    Storage::fake('test');
    config()->set('valuestore.disk', 'test');
    $settings = ['__KEY__' => '__VALUE__'];
    $valuestore = CachedValuestore::make('settings.json', $settings);
    Storage::disk('test')->delete('settings.json');
    expect($valuestore->allStartingWith('__KEY'))->toBe($settings);
    expect($valuestore->allStartingWith('_V'))->toBe([]);
});

test('cache values are updated after put', function () {
    Storage::fake('test');
    config()->set('valuestore.disk', 'test');
    $settings = ['__KEY__' => '__VALUE__'];
    $valuestore = CachedValuestore::make('settings.json', $settings);
    Storage::disk('test')->delete('settings.json');
    expect($valuestore->put('__KEY__', '__UPDATED__'))->toBeInstanceOf(CachedValuestore::class);
    Storage::disk('test')->delete('settings.json');
    expect($valuestore->get('__KEY__'))->toBe('__UPDATED__');
});


test('cache values are updated after prepend', function () {
    Storage::fake('test');
    config()->set('valuestore.disk', 'test');
    $settings = ['__KEY__' => '__VALUE__'];
    $valuestore = CachedValuestore::make('settings.json', $settings);
    Storage::disk('test')->delete('settings.json');
    expect($valuestore->prepend('__KEY__', '__UPDATED__'))->toBeInstanceOf(CachedValuestore::class);
    Storage::disk('test')->delete('settings.json');
    expect($valuestore->get('__KEY__'))->toBe(['__UPDATED__', '__VALUE__']);
});

test('cache values are updated after push', function () {
    Storage::fake('test');
    config()->set('valuestore.disk', 'test');
    $settings = ['__KEY__' => '__VALUE__'];
    $valuestore = CachedValuestore::make('settings.json', $settings);
    Storage::disk('test')->delete('settings.json');
    expect($valuestore->push('__KEY__', '__UPDATED__'))->toBeInstanceOf(CachedValuestore::class);
    Storage::disk('test')->delete('settings.json');
    expect($valuestore->get('__KEY__'))->toBe(['__VALUE__', '__UPDATED__']);
});

test('cache values are updated after forget', function () {
    Storage::fake('test');
    config()->set('valuestore.disk', 'test');
    $settings = ['__KEY__' => '__VALUE__'];
    $valuestore = CachedValuestore::make('settings.json', $settings);
    Storage::disk('test')->delete('settings.json');
    $valuestore->forget('__KEY__');
    expect($valuestore->get('__KEY__'))->toBeNull();
});

test('cache values are updated after flush', function () {
    Storage::fake('test');
    config()->set('valuestore.disk', 'test');
    $settings = ['__KEY__' => '__VALUE__'];
    $valuestore = CachedValuestore::make('settings.json', $settings);
    Storage::disk('test')->delete('settings.json');
    $valuestore->flush();
    expect($valuestore->get('__KEY__'))->toBeNull();
});

test('cache values are updated after flush starting with', function () {
    Storage::fake('test');
    config()->set('valuestore.disk', 'test');
    $settings = ['__KEY__' => '__VALUE__'];
    $valuestore = CachedValuestore::make('settings.json', $settings);
    Storage::disk('test')->delete('settings.json');
    $valuestore->flushStartingWith('__K');
    expect($valuestore->get('__KEY__'))->toBeNull();
});

test('cache values are updated after pull', function () {
    Storage::fake('test');
    config()->set('valuestore.disk', 'test');
    $settings = ['__KEY__' => '__VALUE__'];
    $valuestore = CachedValuestore::make('settings.json', $settings);
    Storage::disk('test')->delete('settings.json');
    $value = $valuestore->pull('__KEY__');
    expect($value)->toBe('__VALUE__');
    expect($valuestore->get('__KEY__'))->toBeNull();
});

test('cache values are updated after increment', function () {
    Storage::fake('test');
    config()->set('valuestore.disk', 'test');
    $settings = ['__KEY__' => 1234];
    $valuestore = CachedValuestore::make('settings.json', $settings);
    Storage::disk('test')->delete('settings.json');
    $valuestore->increment('__KEY__');
    Storage::disk('test')->delete('settings.json');
    expect($valuestore->get('__KEY__'))->toBe(1235);
});

test('cache values are updated after decrement', function () {
    Storage::fake('test');
    config()->set('valuestore.disk', 'test');
    $settings = ['__KEY__' => 1234];
    $valuestore = CachedValuestore::make('settings.json', $settings);
    Storage::disk('test')->delete('settings.json');
    $valuestore->decrement('__KEY__');
    expect(Storage::disk('test')->exists('settings.json'))->toBeTrue();
    Storage::disk('test')->delete('settings.json');
    expect($valuestore->get('__KEY__'))->toBe(1233);
});

test('empty cache reads values from file', function () {
    Storage::fake('test');
    config()->set('valuestore.disk', 'test');
    $settings = ['__KEY__' => '__VALUE__'];
    $valuestore = CachedValuestore::make('settings.json', $settings);
    Storage::disk('test')->put('settings.json', json_encode(['__KEY__' => '__UPDATED__']));
    $valuestore->clearCache();
    expect($valuestore->get('__KEY__'))->toBe('__UPDATED__');
});
