<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <title><?= $title ?></title>
    <style>
        ::-webkit-scrollbar {
            width: 8px;

        }

        ::-webkit-scrollbar-track {
            background-color: #e5e5e5;
        }

        ::-webkit-scrollbar-thumb {
            background: #777777;
            cursor: pointer;
            border-radius: 20px;
            transition: background-color 0.2s ease;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555555;
        }

        * {
            margin: 0;
            padding: 0;
            font-family: Roboto, sans-serif;
            color: #212121;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        form > div {
            display: grid;
            grid-template-columns: 40% 60%;
            margin: 2.5% 0;
        }

        .parent-container {
            display: flex;
            justify-content: space-evenly;
            margin: 0 1vw;
        }

        .parent-container > div {
            width: 47.5%;
        }

        .parent-container > div > * {
            margin: 1.5vh 0;
        }

        .spending-category {
            display: flex;
            flex-direction: column;
        }

        .spending-category > div {
            display: grid;
            grid-template-columns: repeat(3, 33%);
        }

        .income > div:first-child, .spending > div:first-child {
            padding: 2% 0;
            border-bottom: 1px solid #818181;
            margin-bottom: 5%;
        }

        .table-container {
            max-height: 50vh;
            overflow-y: auto;
            overflow-x:visible;
            display: flex;
            justify-content: center;
        }

        table{
            table-layout: fixed;
        }

        table td, table th {
            gap: 0;
            padding: 5px 7px;
            border: none;
            border-bottom: 1px solid #b8b8b8;
        }

        .nav {
            padding: 2%;
        }

        .nav a {
            padding: 0.8% 1.5%;
            margin-left: 0.5%;
            margin-right: 0.5%;
            border-radius: 3px;
            text-decoration: none;
            transition: color 0.2s ease, background-color 0.2s ease;
        }

        .nav a:hover {
            background-color: #424242;
            color: white;
        }

        .delete-button, .insert-button {
            border-radius: 2px;
            border: none;
            padding: 6px;
            outline: none;
            cursor: pointer;
            transition: color 0.2s ease, background-color 0.2s ease;
        }

        .insert-button {
            background-color: #84d6ff;
        }

        .delete-button {
            background-color: transparent;
            color: #e34b4b;
        }

        .insert-button:hover {
            background-color: #4190b7;
            color: white;
        }

        input, select {
            padding: 1%;
        }

        .delete-button:hover {
            color: white;
            background-color: #e34b4b;
        }

        .delete-button:active {
            color: white;
            background-color: #b33535;
        }

        .income-form, .spending-form {
            border: 1px solid #e5e5e5;
            padding: 2%;
            border-radius: 2px;
        }

        .current-money {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 15vh;
        }

        .safe {
            background-color: #b6ffd9;
        }

        .danger {
            background-color: #ffb6b6;
        }

        .filter {
            display: flex;
            justify-content: center;
        }

        .filter > * {
            width: 33%;
        }

        .filter > form {
            display: flex;
            justify-content: center;
            flex-direction: row;
        }

        @media screen and (max-width: 768px){
            .parent-container{
                flex-direction: column;
                align-items: center;
                width:100vw;
            }
            .parent-container > div{
                width:100%;
            }
        }
    </style>
</head>

<body>
<?php
require_once "$_SERVER[DOCUMENT_ROOT]/helpers/connection.php";
require_once "$_SERVER[DOCUMENT_ROOT]/helpers/function.php";
require_once 'nav.php';
?>
</body>

</html>