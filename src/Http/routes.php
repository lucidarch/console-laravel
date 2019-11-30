<?php

namespace Lucid\Console;

use Route;

Route::group(['prefix' => 'lucid'], function () {

    // UI Navigation Routes
    Route::get('/dashboard', function () {
        return view('lucid::dashboard');
    });

    Route::get('/dashboard/services', function () {
        return view('lucid::services');
        // return view('lucid::mdl-layout');
    });

    Route::get('/dashboard/domains', function () {
        return view('lucid::domains');
    });

    Route::get('/dashboard/features', function () {
        return view('lucid::features');
    });

    Route::get('/dashboard/logs', function () {
        return view('lucid::logs');
    });

    // Data Routes
    Route::post('/search', function () {
        // search for the query in features and jobs
        return (new Controller())->fuzzyFind(request()->input('query'));
    });

    Route::get('/services', function () {
        return (new Controller())->listServices();
    });

    Route::get('/services/{slug}/features', function ($slug) {
        return (new Controller())->listFeatures($slug);
    });

    Route::post('/services', function () {
        return app(\Lucid\Console\Generators\ServiceGenerator::class)->generate(request()->input('name'))->toArray();
    });

    Route::get('/features/{name}', function ($name) {
        return (new Controller())->findFeature($name)->toArray();
    });

    Route::get('/domains', function () {
        return (new Controller())->listDomains();
    });

    Route::get('/domains/{name}/jobs', function ($name) {
        return (new Controller())->listJobs(\Lucid\Console\Str::domain($name));
    });

    Route::get('/jobs', function () {
        return (new Controller())->listJobs();
    });

    Route::get('/jobs/{name}', function ($name) {
        return (new Controller())->findJob($name)->toArray();
    });

    Route::post('/jobs', function () {
        // create job
        $title = request()->input('title');
        $domain = request()->input('domain');

        return app(\Lucid\Console\Generators\JobGenerator::class)->generate($title, $domain)->toArray();
    });

    Route::post('/features', function () {
        // create feature
        $title = request()->input('title');
        $service = request()->input('service');
        $jobs = request()->input('jobs');

        return app(\Lucid\Console\Generators\FeatureGenerator::class)->generate($title, $service, $jobs)->toArray();
    });

    Route::get('/analysis', function () {
        return (new \Lucid\Console\Analyser())->analyse();
    });

});

class Controller
{
    use Finder;
}
