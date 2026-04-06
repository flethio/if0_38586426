<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>FreedomGDPS!!11 - Tools - Advantages</title>
  <link rel="icon" type="image/png" href="https://fless.ps.fhgdps.com/dashboard/icon.png"/>

  <style>
    * { margin:0; padding:0; box-sizing:border-box; }

    /* Font Pusab */
    @font-face {
      font-family: 'Pusab';
      src: url('https://fless.rf.gd/gauntlet/assets/Pusab.ttf') format('truetype');
      font-display: swap;
    }

    body {
      font-family: 'Pusab', sans-serif;
      background-color: #121212;
      background-image: url('https://fless.rf.gd/gauntlet/assets/img/bg-pattern.png');
      background-repeat: repeat;
      animation: bgScroll 40s linear infinite;
      color: #e0e0e0;
      text-align: center;
      padding: 2rem;
      min-height: 100vh;
    }

    @keyframes bgScroll {
      from { background-position: 0 0; }
      to   { background-position: -1000px 0; }
    }

    /* Bobbing Animation */
    .bobbing {
      display: inline-block;
      animation: bob 2.5s ease-in-out infinite;
    }
    @keyframes bob {
      0%,100% { transform: translateY(0); }
      50%     { transform: translateY(-8px); }
    }

    h1 {
      font-size: 2.2rem;
      margin-bottom: 0.5rem;
      color: #ffffff;
    }
    h1 .bobbing { animation-delay: 0s; }

    p {
      font-size: 1rem;
      color: #bbbbbb;
      margin-bottom: 2rem;
    }

    .container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px,1fr));
      gap: 1rem;
      max-width: 800px;
      margin: 0 auto 2rem;
    }

    .container a {
      display: block;
      padding: 1rem;
      background: #1e1e1e;
      color: #ddd;
      text-decoration: none;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.4);
      transition: background 0.2s, transform 0.2s;
      font-weight: bold;
    }
    .container a:hover {
      background: #2a2a2a;
      transform: translateY(-3px);
    }

    .nav {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px,1fr));
      gap: 1rem;
      max-width: 600px;
      margin: 0 auto 2rem;
    }
    .nav a {
      display: block;
      padding: 0.75rem;
      background: #fff;
      color: #000;
      text-decoration: none;
      border-radius: 5px;
      transition: background 0.2s, transform 0.1s;
      font-weight: bold;
    }
    .nav a:hover {
      background: #ddd;
      transform: translateY(-2px);
    }

    footer {
      margin-top: 2rem;
      font-size: 0.85rem;
      color: #888;
    }
  </style>
</head>
<body>
  <h1><span class="bobbing">FrGDPS Tools Page</span> </h1>
  <p class="bobbing">Di Dukung GDPSFH &amp; ObeyGDBot:</p>

  <div class="container">
<a href="https://fless.ps.fhgdps.com/dashboard/stats/songList.php" target="_blank">Search Songs</a>
  <a
  	<a href="https://fless.ps.fhgdps.com/dashboard/songs" target="_blank">Upload Song File</a>
  <a href="https://fless.ps.fhgdps.com/dashboard/reupload/songAdd.php">Upload Song Link</a>
<a href="https://fless.ps.fhgdps.com/dashboard/sfxs/">Upload SFX File</a>
  <a href="https://fless.ps.fhgdps.com/dashboard/levels/levelReupload.php">Reupload Level</a>
    <a href="https://sociabuzz.com/ameliapt/" target="_blank">Donate / Dukung</a>
  </div>

  <div class="nav">
  	
    <a href="/index.php" >Beranda</a>
    <a href="/pap/">Privacy And Policy</a>
  </div>

  <footer>&copy; <?= date("Y") ?> FrGDPS by Fless & Amelia</footer>
</body>
</html>