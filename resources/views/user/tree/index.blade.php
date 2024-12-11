@extends('layouts.app')

@section('css')
    <style>
        /*----------------genealogy-scroll----------*/

        .genealogy-scroll::-webkit-scrollbar {
            width: 5px;
            height: 8px;
        }

        .genealogy-scroll::-webkit-scrollbar-track {
            border-radius: 10px;
            background-color: #e4e4e4;
        }

        .genealogy-scroll::-webkit-scrollbar-thumb {
            background: #212121;
            border-radius: 10px;
            transition: 0.5s;
        }

        .genealogy-scroll::-webkit-scrollbar-thumb:hover {
            transition: 0.5s;
        }


        /*----------------genealogy-tree----------*/
        .genealogy-body {
            white-space: nowrap;
            overflow-y: hidden;
            padding: 50px;
            min-height: 500px;
            padding-top: 10px;
            text-align: center;
        }

        .genealogy-tree {
            display: inline-block;
        }

        .genealogy-tree ul {
            padding-top: 20px;
            position: relative;
            padding-left: 0px;
            display: flex;
            justify-content: center;
        }

        .genealogy-tree li {
            float: left;
            text-align: center;
            list-style-type: none;
            position: relative;
            padding: 20px 5px 0 5px;
        }

        .genealogy-tree li::before,
        .genealogy-tree li::after {
            content: '';
            position: absolute;
            top: 0;
            right: 50%;
            border-top: 2px solid #ccc;
            width: 50%;
            height: 18px;
        }

        .genealogy-tree li::after {
            right: auto;
            left: 50%;
            border-left: 2px solid #ccc;
        }

        .genealogy-tree li:only-child::after,
        .genealogy-tree li:only-child::before {
            display: none;
        }

        .genealogy-tree li:only-child {
            padding-top: 0;
        }

        .genealogy-tree li:first-child::before,
        .genealogy-tree li:last-child::after {
            border: 0 none;
        }

        .genealogy-tree li:last-child::before {
            border-right: 2px solid #ccc;
            border-radius: 0 5px 0 0;
            -webkit-border-radius: 0 5px 0 0;
            -moz-border-radius: 0 5px 0 0;
        }

        .genealogy-tree li:first-child::after {
            border-radius: 5px 0 0 0;
            -webkit-border-radius: 5px 0 0 0;
            -moz-border-radius: 5px 0 0 0;
        }

        .genealogy-tree ul ul::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            border-left: 2px solid #ccc;
            width: 0;
            height: 20px;
        }

        .genealogy-tree li a {
            text-decoration: none;
            color: #666;
            font-family: arial, verdana, tahoma;
            font-size: 11px;
            display: inline-block;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
        }

        .genealogy-tree li a:hover,
        .genealogy-tree li a:hover+ul li a {
            transition: 0.5s;
            opacity: 0.5;
        }

        .genealogy-tree li a:hover+ul li::after,
        .genealogy-tree li a:hover+ul li::before,
        .genealogy-tree li a:hover+ul::before,
        .genealogy-tree li a:hover+ul ul::before {
            border-color: #fff;
        }

        /*--------------memeber-card-design----------*/

        .member-view-box {
            padding-bottom: 10px;
            text-align: center;
            border-radius: 4px;
            position: relative;
            border: 1px;
            border-style: solid;
        }

        .member-image {
            padding: 10px;
            width: 120px;
            position: relative;
        }

        .member-image img {
            width: 100px;
            height: 100px;
            border-radius: 6px;
            background-color: #fff;
            z-index: 1;
        }

        .member-header {
            padding: 5px 0;
            text-align: center;
            background: #345;
            color: #fff;
            font-size: 14px;
            border-radius: 4px 4px 0 0;
        }

        .member-footer {
            text-align: center;
        }

        .member-footer div.name {
            color: #000;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .member-footer div.downline {
            color: #000;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .img-thumbnail {
            max-width: 250px;
        }
    </style>
@endsection
@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm rounded">
            <div class="card-header text-center">
                <h3>{{ auth()->user()->name }}'s Downline Tree</h3>
            </div>
            <div class="card-body text-center">
                <div class="body genealogy-body genealogy-scroll">
                    <div class="genealogy-tree">
                        <ul>
                            <li>
                                <!-- Auth User (Root) -->
                                <a href="javascript:void(0);">
                                    <div class="member-view-box">
                                        <div class="bg-light p-2">
                                            <span class="text-white fs-5">{{ auth()->user()->username }}</span>
                                            <br>
                                            <span
                                                class="text-white fs-5">{{ Number::currency(auth()->user()->investment(),'MYR','ms_MY') }}</span>
                                        </div>
                                        <div class="member-image w-100 text-center">
                                            <img src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : asset('assets/images/avatar.png') }}"
                                                alt="Member" class="img-fluid rounded img-thumbnail">
                                        </div>
                                    </div>
                                </a>

                                <!-- Recursively Render Downline -->
                                <ul class="active">
                                    @foreach (auth()->user()->downlineTree() as $downlineNode)
                                        @include('inc.tree-downline', [
                                            'node' => $downlineNode,
                                        ])
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
