<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Article;
use Faker\Generator;

class ExampleTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testCreateArticle(){
        //Vérifie qu'il n'y a pas d'articles présent dans la base de données
        $articles = Article::all();
        $this->assertCount(0, $articles);

        //Insertion d'un article
        $article = factory(Article::class)->create()->fresh();
        $articles = Article::all();
        $this->assertCount(1, $articles);

        //Génération de fausses données
        $titre = $this->faker->name;
        $content = $this->faker->sentence;

        //Vérification de notre requete HTTP POST
        $response = $this->withHeaders([
            'Content-type' => 'application/json',
        ])->json('POST', '/api/articles', [
            'titre' => $titre,
            'contenu' => $content
        ])->assertStatus(201);

        //Vérification que l'article a bien été crée et qu'il existe dans la BDD
        $articles = Article::all();
        $this->assertCount(2, $articles);
        $this->assertDatabaseHas('articles', ['titre'=> $titre, 'contenu'=> $content]);

        //Test avec un champ invalide 
        $response = $this->withHeaders([
            'Content-type' => 'application/json',
        ])->json('POST', '/api/articles', [
            'contenu' => $content
        ])->assertStatus(400);

    }

    public function testUpdateArticle(){
        //Generation de fausse données
        $titre = $this->faker->name;
        $content = $this->faker->sentence;

        //Ajout d'un article pour le modifier
        $article = factory(Article::class)->create()->fresh();
        $id = $article->id;

        //Appel la méthode HTTP avec des données valides
        $response = $this->withHeaders([
            'Content-type' => 'application/json',
        ])->json('PUT', '/api/articles/'.$id, [
            'titre' => $titre,
            'contenu' => $content
        ])->assertStatus(204);
        $this->assertDatabaseHas('articles', ['titre'=> $titre, 'contenu'=> $content]);

        //Appel la méthode HTTP avec un id inexistant
        $invalidId = Article::all()->count()+1;
        $response = $this->withHeaders([
            'Content-type' => 'application/json',
        ])->json('PUT', '/api/articles/'.$invalidId, [
            'titre' => $titre,
            'contenu' => $content
        ])->assertStatus(404);
        $this->assertDatabaseHas('articles', ['titre'=> $titre, 'contenu'=> $content]);

    }




}
