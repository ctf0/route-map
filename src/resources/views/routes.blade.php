<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Routes</title>

    {{-- Styles --}}
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/RouteMap/style.css') }}"/>
</head>
<body>
    <section id="app" v-cloak>
        <div class="container is-fluid">
            <div class="columns">
                <div class="column">

                    <route-map inline-template v-cloak :group-names="{{ json_encode(array_keys($routes_list)) }}">
                        <div>
                            <div class="level">
                                <div class="level-left">
                                    <div class="level-item">
                                        <p class="title">Routes "<span>{{ $total }}</span>"</p>
                                    </div>
                                    <div class="level-item">
                                        <button class="button is-light" @click="toggleExpand()">
                                            <template v-if="expand">
                                                <span class="icon"><icon name="arrow-left" scale="0.8"></icon></span>
                                                <span>Collapse</span>
                                            </template>
                                            <template v-else>
                                                <span>Expand</span>
                                                <span class="icon"><icon name="arrow-right" scale="0.8"></icon></span>
                                            </template>
                                        </button>
                                    </div>
                                </div>

                                <div class="level-right">
                                    {{-- search --}}
                                    <div class="level-right">
                                        <div class="field has-addons has-addons-right">
                                            {{-- type --}}
                                            <p class="control">
                                                <span class="select">
                                                    <select v-model="searchFieldType">
                                                        <option v-for="n in searchFields" :key="n">@{{ n }}</option>
                                                    </select>
                                                </span>
                                            </p>
                                            {{-- input --}}
                                            <p class="control has-icons-left">
                                                <input class="input"
                                                    ref="search"
                                                    type="text"
                                                    v-model="searchFor"
                                                    placeholder="Find ...">
                                                <span class="icon is-left"><icon name="search"></icon></span>
                                            </p>
                                            {{-- clear --}}
                                            <p class="control">
                                                <button class="button is-black"
                                                    :disabled="!searchFor"
                                                    @click="resetSearch()">
                                                    <span class="icon"><icon name="times"></icon></span>
                                                </button>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <table class="table is-hoverable is-fullwidth">
                                <thead>
                                    <tr>
                                        <th class="is-link static-cell">Group</th>
                                        <th class="is-link static-cell">Methods</th>
                                        <th class="is-link static-cell hide-domain">Domain</th>
                                        <th class="is-link static-cell">Url</th>
                                        <th class="is-link static-cell">Name</th>
                                        <th class="is-link static-cell">Action</th>
                                        <th class="is-link">Middleware</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($routes_list as $item => $data)
                                        <tr data-toggle data-group-name="{{ $item }}" @click="toggleGroup('{{ $item }}')">
                                            <th colspan="7" class="is-dark" data-group>{{ $item }} : Nº.<span>{{ count($data) }}</span></th>
                                        </tr>

                                        @for($i = 0; $i < count($data) ; $i++)
                                            <tr data-group-name="{{ $item }}">
                                                <td class="empty-cell"></td>
                                                <td class="static-cell">
                                                    @foreach($data[$i]->methods() as $method)
                                                        <p data-methods class="methods {{ $method_colours[$method] }}">{{ $method }}</p>
                                                    @endforeach
                                                </td>
                                                <td class="domain" data-domain>{{ $data[$i]->domain() }}</td>
                                                <td class="static-cell">
                                                    @if(app('route-map')->isUrl($data[$i]->methods(), $data[$i]->uri()))
                                                        <a data-url href="{{ url($data[$i]->uri()) }}">{{ $data[$i]->uri() }}</a>
                                                    @else
                                                        <span data-url>{{ $data[$i]->uri() }}</span>
                                                    @endif
                                                </td>
                                                <td class="static-cell" data-name>{{ $data[$i]->getName() }}</td>
                                                <td class="static-cell">
                                                    @if($data[$i]->getActionName() == 'Closure')
                                                        <span data-action>{{ $data[$i]->getActionName() }}</span>
                                                    @else
                                                        <a data-action href="{{ app('route-map')->getUrl($data[$i]->getActionName()) }}">{{ $data[$i]->getActionName() }}</a>
                                                    @endif
                                                </td>
                                                <td data-middleware>
                                                    @if(is_callable([$data[$i], 'controllerMiddleware']))
                                                        {{ implode(', ', array_map($middlewareClosure, array_merge($data[$i]->middleware(), $data[$i]->controllerMiddleware()))) }}
                                                    @else
                                                        {{ implode(', ', $data[$i]->middleware()) }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endfor
                                    @endforeach
                                </tbody>
                            </table>

                            <scroll></scroll>
                        </div>
                    </route-map>

                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset("js/app.js") }}"></script>
</body>
</html>
