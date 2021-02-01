<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1>Projects and tasks</h1>
                    <?php //dump($projects); ?>
                    <ul class="list-group">
                    <?php foreach($projects as $project){ ?>
                        <li  class="list-group-item">{{ $project['title'] }}

                        <?php if( !empty($project['tasks']) ){ ?>
                            <ul class="list-group"> 
                            <?php foreach($project['tasks'] as $task){ ?>
                                <li  class="list-group-item">{{ $task['name'] }} ( {{ $task['points'] }} ) </li>
                            <?php } ?>
                            </ul>
                        <?php } ?>

                        </li>

                    <?php } ?>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
