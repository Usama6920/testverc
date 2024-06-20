<html>

<head>
    <title>Congratulation</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <style>

        body{
              font-family: 'Open Sans', sans-serif;
            background-color: rgb(238, 240, 247);
            display: flex;
            justify-content: center;
            align-items: center;

        }
        .main-div{


            display: flex;
            justify-content: center;
        }
        .my-container{
            background-color: rgb(255, 255, 255);
            padding:6rem;
            border-radius: 30px;
        }
        img{
            max-width: 8rem;
            display: block;
            margin: 0px auto;
        }
        p{
            margin-top: 2.5rem;
            margin-bottom: 0.2rem;
            text-align: center;
            color: rgb(138, 138, 138);
        }
        h1{
            margin-top: 0rem;
            color: rgb(70, 70, 70);
            text-align: center;
        }
        button{
            border: none;
            border-radius: 10px;
            padding: 0.8rem 3rem;
            margin-top: 1rem;
        }
        @media screen and (max-width: 400px) {
            .my-container{

                padding:4.8rem;
                border-radius: 20px;
            }
        }

    </style>


</head>


<body>

    <div class="main-div">
        <div class="my-container">
            <img src="{{asset('images/success.png')}}" alt="success icon">
            <p>{{$content}}</p>
            <h1>{{$heading}}</h1>
          <div style="justify-content: center;display: flex;">
                <button onclick="window.close()">Close</button>
          </div>

        </div>

    </div>
</body>


<script>

</script>
</html>
