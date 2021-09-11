<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client as GuzzleHttp;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = new GuzzleHttp;
        $response = $client->get('https://pokeapi.co/api/v2/pokemon')
            ->getBody()
            ->getContents();

        $res = json_decode($response);
        // dd($res->results);

        $pokeLists = $res->results;

        return view('home', compact('pokeLists'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $client = new GuzzleHttp;
        $getDetails = $client->get('https://pokeapi.co/api/v2/pokemon/'.$id)
            ->getBody()
            ->getContents();
        $poke = json_decode($getDetails);
        // dd($poke);

        if(count($poke->types) > 1) {
            $arrType = [];
            foreach($poke->types as $type) {
                array_push($arrType, ucwords($type->type->name));
            }

            $type =  implode(', ', $arrType);
        } else {
            $type = ucwords($poke->types[0]->type->name);
        }

        $species = '';
        $getSpecies = $client->get('https://pokeapi.co/api/v2/pokemon-species/'.$id)
            ->getBody()
            ->getContents();
        // dd(json_decode(($getSpecies)));

        // dd($poke->sprites->other->dream_world->front_default);

        return view('detail', compact('poke', 'type'));
    }

    public function list() 
    {
        return view('list');
    }
}
