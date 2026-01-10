<?php

use App\Models\Person;
use Illuminate\Support\Carbon;

test('person model create pattern', function () {
    $inputName = 'taro';
    $inputAge = 15;
    $workTime = Carbon::now();

    expect(Person::all()->count() === 0)->toBeTrue();
    $department = Person::create([
        'name' => $inputName,
        'age'  => $inputAge,
    ]);

    expect(Person::all()->count() === 1)->toBeTrue()
        ->and($department->name === $inputName)->toBeTrue()
        ->and($department->age === $inputAge)->toBeTrue()
        ->and($department->created_at->toAtomString()
            === $workTime->toAtomString())->toBeTrue()
        ->and($department->updated_at->toAtomString()
            === $workTime->toAtomString())->toBeTrue();
});


test('person model update pattern', function () {
    $inputName = 'taro';
    $updateName = 'jiro';
    $inputAge = 15;
    $updateAge = 20;
    $beforeTime = Carbon::now();

    $department = Person::create([
        'name' => $inputName,
        'age'  => $inputAge,
    ]);

    sleep(1);
    $afterTime = Carbon::now();

    expect(Person::all()->count() === 1)->toBeTrue();
    $department->update(['name' => $updateName, 'age' => $updateAge]);

    expect(Person::all()->count() === 1)->toBeTrue()
        ->and($department->name === $updateName)->toBeTrue()
        ->and($department->name === $inputName)->toBeFalse()
        ->and($department->age === $updateAge)->toBeTrue()
        ->and($department->age === $inputAge)->toBeFalse()
        ->and($department->created_at->toAtomString()
            === $beforeTime->toAtomString())->toBeTrue()
        ->and($department->created_at->toAtomString()
            === $afterTime->toAtomString())->toBeFalse()
        ->and($department->updated_at->toAtomString()
            === $afterTime->toAtomString())->toBeTrue();

});

test('person model delete pattern', function () {
    $inputName = 'taro';
    $inputAge = 15;

    $department = Person::create([
        'name' => $inputName,
        'age'  => $inputAge,
    ]);

    expect(Person::all()->count() === 1)->toBeTrue();
    $department->delete();

    expect(Person::all()->count() === 0)->toBeTrue()
        ->and(Person::withTrashed()->count() === 1)->toBeTrue();
});
