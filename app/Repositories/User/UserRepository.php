<?php

namespace App\Repositories\User;

use Exception;
use App\Models\User;
use Illuminate\Support\Arr;

class UserRepository implements UserRepositoryInterface
{

    private $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Checks if the user type allows transactions
     *
     * @param integer $user_id
     * @return boolean
     */
    public function checkAuthorizationUser(int $user_id)
    {
        $user = $this->model->findOrFail($user_id);

        if ($user->type == $this->model::TYPES['shopkeeper']) {
            throw new Exception("Shopkeepers cannot carry out transactions");
        }
       
        return true;
    }

    /**
     * Adds user balance
     *
     * @param integer $user_id
     * @param float $value
     * @return boolean
     */
    public function addBalance(int $user_id, float $value)
    {
        $user = $this->model->findOrFail($user_id);
        $user->balance_wallet += $value;
        $user->save();

        return true;
    }

    /**
     * Subtract user balance
     *
     * @param integer $user_id
     * @param float $value
     * @return boolean
     */
    public function subtractBalance(int $user_id, float $value)
    {
        $user = $this->model->findOrFail($user_id);

        if ($value > $user->balance_wallet) {
            throw new Exception("Insufficient funds.");
        }

        $user->balance_wallet -= $value;
        $user->save();

        return true;
    }
}
