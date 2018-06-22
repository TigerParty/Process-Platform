<?php

// Process
Breadcrumbs::register('admin.process.index', function ($breadcrumbs) {
    $breadcrumbs->push('Processes', route('admin.process.index'));
});
// Process> Step
Breadcrumbs::register('admin.step.show', function ($breadcrumbs, $step) {
    $breadcrumbs->push($step->process->name, route('admin.process.index',['acitveID'=> $step->process->id]));
    $breadcrumbs->push($step->name, route('admin.process.index'));
});
// Location
Breadcrumbs::register('admin.region.index', function ($breadcrumbs) {
    $breadcrumbs->push('Location', route('admin.region.index'));
});
