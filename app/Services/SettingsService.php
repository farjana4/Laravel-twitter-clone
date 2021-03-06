<?php

namespace App\Services;

use App\Models\User;
use Exception;

class SettingsService
{
    public function updateAttribute(string $attribute, string $value)
    {
        /** @var User $user */
        $user = auth()->user();

        try {
            $user->update([
                $attribute => $value,
                ]);
        } catch (Exception $exception) {
            throw new Exception(sprintf('%s could not be updated.', ucfirst($attribute)));
        }
    }
}
