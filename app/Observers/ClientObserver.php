<?php
namespace App\Observers;

use App\Client;
use App\ClientEmail;
use Illuminate\Support\Facades\Auth;
use App\ClientPhone;

class ClientObserver
{
    /**
     * Listen to the Client saved event.
     *
     * @param  Client  $user
     * @return void
     */
    public function saved(Client $client)
    {
        $email = ClientEmail::whereClientId($client->id)->whereEmail($client->email)->first();
        if (!$email) {
            $email = new ClientEmail();
            $email->client_id = $client->id;
            $email->email = $client->email;
            $email->created_by = Auth::id();
            $email->created_date = date('Y-m-d H:i:s');
            $email->modified_date = date('Y-m-d H:i:s');
            $email->modified_by = Auth::id();
            $email->save();
        }

        $phone = ClientPhone::whereClientId($client->id)->wherePhone($client->phone)->first();
        if (!$phone) {
            $phone = new ClientPhone();
            $phone->client_id = $client->id;
            $phone->phone = $client->phone;
            $phone->created_by = Auth::id();
            $phone->created_date = date('Y-m-d H:i:s');
            $phone->modified_date = date('Y-m-d H:i:s');
            $phone->modified_by = Auth::id();
            $phone->save();
        }
    }
    
}