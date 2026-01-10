<?php

use App\Models\Person;
use Illuminate\Support\Carbon;

test('person model factory no parameter test', function () {
    $workTime = Carbon::now();

    expect(Person::all()->count() === 0)->toBeTrue();
    $person = Person::factory()->create();

    expect(Person::all()->count() === 1)->toBeTrue()
        ->and(isset($person->name))->toBeTrue()
        ->and(isset($person->age))->toBeTrue()
        ->and($person->created_at->toAtomString()
            === $workTime->toAtomString())->toBeTrue()
        ->and($person->updated_at->toAtomString()
            === $workTime->toAtomString())->toBeTrue();
});

test('person model factory test', function () {
    $inputName = 'taro';
    $inputAge = 15;
    $workTime = Carbon::now();

    expect(Person::all()->count() === 0)->toBeTrue();
    $person = Person::factory()->create([
        'name' => $inputName,
        'age'  => $inputAge,
    ]);

    expect(Person::all()->count() === 1)->toBeTrue()
        ->and($person->name === 'Mr.'.ucwords($inputName))->toBeTrue()
        ->and($person->age === $inputAge)->toBeTrue()
        ->and($person->created_at->toAtomString()
            === $workTime->toAtomString())->toBeTrue()
        ->and($person->updated_at->toAtomString()
            === $workTime->toAtomString())->toBeTrue();
});

test('person model create pattern', function () {
    $inputName = 'taro';
    $inputAge = 15;
    $workTime = Carbon::now();

    expect(Person::all()->count() === 0)->toBeTrue();
    $person = Person::create([
        'name' => $inputName,
        'age'  => $inputAge,
    ]);

    expect(Person::all()->count() === 1)->toBeTrue()
        ->and($person->name === 'Mr.'.ucwords($inputName))->toBeTrue()
        ->and($person->age === $inputAge)->toBeTrue()
        ->and($person->created_at->toAtomString()
            === $workTime->toAtomString())->toBeTrue()
        ->and($person->updated_at->toAtomString()
            === $workTime->toAtomString())->toBeTrue();
});


test('person model update pattern', function () {
    $inputName = 'taro';
    $updateName = 'jiro';
    $inputAge = 15;
    $updateAge = 20;
    $beforeTime = Carbon::now();

    $person = Person::create([
        'name' => $inputName,
        'age'  => $inputAge,
    ]);

    sleep(1);
    $afterTime = Carbon::now();

    expect(Person::all()->count() === 1)->toBeTrue();
    $person->update(['name' => $updateName, 'age' => $updateAge]);

    expect(Person::all()->count() === 1)->toBeTrue()
        ->and($person->name === 'Mr.'.ucwords($updateName))->toBeTrue()
        ->and($person->name === $inputName)->toBeFalse()
        ->and($person->age === $updateAge)->toBeTrue()
        ->and($person->age === $inputAge)->toBeFalse()
        ->and($person->created_at->toAtomString()
            === $beforeTime->toAtomString())->toBeTrue()
        ->and($person->created_at->toAtomString()
            === $afterTime->toAtomString())->toBeFalse()
        ->and($person->updated_at->toAtomString()
            === $afterTime->toAtomString())->toBeTrue();

});

test('person model soft delete pattern', function () {
    $inputName = 'taro';
    $inputAge = 15;

    $person = Person::create([
        'name' => $inputName,
        'age'  => $inputAge,
    ]);

    expect(Person::all()->count() === 1)->toBeTrue();
    $person->delete();

    expect(Person::all()->count() === 0)->toBeTrue()
        ->and(Person::withTrashed()->count() === 1)->toBeTrue();
});

test('person model force delete pattern', function () {
    $inputName = 'taro';
    $inputAge = 15;

    $person = Person::create([
        'name' => $inputName,
        'age'  => $inputAge,
    ]);

    expect(Person::all()->count() === 1)->toBeTrue();
    $person->forceDelete();

    expect(Person::all()->count() === 0)->toBeTrue()
        ->and(Person::withTrashed()->count() === 0)->toBeTrue();
});

test('person model under 15 pattern', function () {
    $inputName = 'taro';
    $inputAge = 14;
    Person::create([
        'name' => $inputName,
        'age'  => $inputAge,
    ]);
})->throws(InvalidArgumentException::class,
    "under fifteen");
