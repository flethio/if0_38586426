<?php
// dashboard.php
session_start();
?><!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <title>GDIPS Dashboard</title>
  <style>
    /* RESET & BASE */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: sans-serif;
      background: #121212;
      color: #eee;
      padding: 1rem;
      min-height: 100vh;
    }

    h1 {
      text-align: center;
      margin-bottom: 1rem;
    }

    /* TABS */
    .tabs {
      display: flex;
      gap: .5rem;
      overflow-x: auto;
      margin-bottom: 1rem;
    }

    .tab {
      padding: .5rem 1rem;
      background: #1e1e1e;
      color: #ccc;
      border-radius: 4px;
      cursor: pointer;
      flex-shrink: 0;
      display: flex;
      align-items: center;
      gap: .3rem;
    }

    .tab.active {
      background: #4fc3f7;
      color: #121212;
    }

    /* PANELS */
    .content {
      display: none;
    }

    .content.active {
      display: block;
    }

    /* BOX */
    .box {
      background: #1a1a1a;
      padding: 1rem;
      border-radius: 6px;
      margin-bottom: 1rem;
    }

    input,
    textarea,
    button {
      width: 100%;
      padding: .6rem;
      margin: .5rem 0;
      border: none;
      border-radius: 4px;
      font-size: 1rem;
    }

    button {
      background: #4fc3f7;
      color: #121212;
      cursor: pointer;
    }

    button:hover {
      filter: brightness(1.1);
    }

    /* FALLBACK */
    pre {
      background: #000;
      padding: 1rem;
      overflow-x: auto;
      border-radius: 4px;
    }

    /* FEATURED CARD */
    .featured-card {
      background: #222;
      padding: 1rem;
      border-radius: 6px;
      box-shadow: 0 0 8px rgba(255, 0, 85, 0.5);
    }

    .featured-card h3 {
      margin-bottom: .5rem;
      color: #ff0055;
    }

    .featured-card p {
      margin: .3rem 0;
      font-size: .95rem;
    }

    .featured-card .meta {
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
      font-size: .9rem;
    }

    .featured-card .meta span {
      background: #333;
      padding: .3rem .6rem;
      border-radius: 4px;
    }

    /* STATS GRID */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
      gap: 1rem;
      margin-top: 1rem;
    }

    .stat-card {
      background: #222;
      padding: .8rem;
      border-radius: 6px;
      text-align: center;
      box-shadow: 0 0 6px rgba(79, 195, 247, 0.5);
    }

    .stat-card h3 {
      font-size: 1rem;
      margin-bottom: .4rem;
      color: #4fc3f7;
    }

    .stat-card p {
      font-size: .9rem;
      color: #ddd;
    }
  </style>
</head>

<body>

  <h1>GDIPS Dashboard</h1>
  <div class="tabs">
    <div class="tab active" data-tab="login">🔐 Login</div>
    <div class="tab" data-tab="search">🔍 Cari Level</div>
    <div class="tab" data-tab="featured">🔥 Featured</div>
    <div class="tab" data-tab="stats">📊 Stats</div>
    <div class="tab" data-tab="profile">👤 Profile</div>
    <!-- <div class="tab" data-tab="addSong">🎵 Upload Song</div> -->
    <div class="tab" data-tab="makePost">✏️ Buat Post</div>
    <div class="tab" data-tab="whoRated">⭐ Who Rated</div>
  </div>

  <div id="login" class="content active">
    <div class="box">
      <h2>Login GDPS</h2>
      <input id="login-user" placeholder="Username">
      <input id="login-pass" placeholder="Password" type="password">
      <button id="btnLogin">🔑 Masuk</button>
      <pre id="login-res"></pre>
    </div>
  </div>

  <div id="search" class="content">
    <div class="box">
      <h2>Cari Level</h2>
      <input id="search-id" placeholder="Level ID">
      <button id="btnSearch">🔎 Cari</button>
      <pre id="search-res"></pre>
    </div>
  </div>

  <div id="featured" class="content">
    <div class="box">
      <h2>🔥 Featured Level</h2>
      <div id="feat-res">Memuat…</div>
    </div>
  </div>

  <div id="stats" class="content">
    <div class="box">
      <h2>📊 Server Stats</h2>
      <div id="stats-res">Memuat…</div>
    </div>
  </div>

  <div id="profile" class="content">
    <div class="box">
      <h2>👤 Profile User</h2>
      <input id="profile-acc" placeholder="👥 Account ID">
      <button id="btnProfile">🔎 Muat Profil</button>
      <pre id="profile-res"></pre>
    </div>
  </div>

  <!-- <div id="addSong" class="content">
    <div class="box">
      <h2>🎵 Upload Song</h2>
      <input id="song-name" placeholder="Song Name">
      <input id="song-author" placeholder="Author">
      <input id="song-download" placeholder="Download URL">
      <button id="btnAddSong">⬆️ Upload</button>
      <pre id="addSong-res"></pre>
    </div>
  </div> -->

  <div id="makePost" class="content">
    <div class="box">
      <h2>✏️ Buat Post</h2>
      <input id="post-auth" placeholder="Auth Token">
      <textarea id="post-content" placeholder="Isi Post…"></textarea>
      <button id="btnMakePost">📨 Kirim</button>
      <pre id="makePost-res"></pre>
    </div>
  </div>

  <div id="whoRated" class="content">
    <div class="box">
      <h2>⭐ Who Rated Level</h2>
      <input id="wr-level" placeholder="Level ID">
      <button id="btnWhoRated">🔍 Cari</button>
      <pre id="whoRated-res"></pre>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const api = 'https://gdi.ps.fhgdps.com/dashboard/api/';
      const tabs = document.querySelectorAll('.tab'),
        panels = document.querySelectorAll('.content');

      tabs.forEach(t => {
        t.addEventListener('click', () => {
          tabs.forEach(x => x.classList.remove('active'));
          panels.forEach(x => x.classList.remove('active'));
          t.classList.add('active');
          document.getElementById(t.dataset.tab).classList.add('active');
        });
      });

      const v = id => encodeURIComponent(document.getElementById(id).value);
      const r = (id, data) => document.getElementById(id).textContent = JSON.stringify(data, null, 2);

      // Login
      document.getElementById('btnLogin').onclick = () => {
        fetch(api + 'login.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: `userName=${v('login-user')}&password=${v('login-pass')}`
        })
          .then(r => r.json()).then(j => r('login-res', j)).catch(e => r('login-res', { error: e }));
      };

      // Search
      document.getElementById('btnSearch').onclick = () => {
        fetch(api + 'searchLevel.php?level=' + v('search-id'))
          .then(r => r.json()).then(j => r('search-res', j)).catch(e => r('search-res', { error: e }));
      };

      // Featured
      fetch(api + 'getLastFeaturedID.php')
        .then(r => r.json())
        .then(f => f.success
          ? fetch(api + 'searchLevel.php?level=' + f.id).then(r => r.json()).then(j => renderFeatured(j.level))
          : document.getElementById('feat-res').textContent = f.message
        ).catch(e => document.getElementById('feat-res').textContent = 'Error');

      function renderFeatured(l) {
        const d = new Date(l.timestamps.uploadDate * 1000).toLocaleDateString();
        document.getElementById('feat-res').innerHTML = `
      <div class="featured-card">
        <h3>🎮 ${l.name}</h3>
        <p><i>${l.desc || '– no description –'}</i></p>
        <div class="meta">
          <span>⭐ ${l.stats.stars}</span>
          <span>🔥 Epic:${l.stats.epic ? 'Yes' : 'No'}</span>
          <span>❤️ ${l.stats.likes}</span>
          <span>📥 ${l.stats.downloads}</span>
          <span>💎 ${l.stats.requestedStars}</span>
        </div>
        <div class="meta">
          <span>🎯 ${l.diffuculty.name}</span>
          <span>👤 ${l.author.username}</span>
          <span>📅 ${d}</span>
        </div>
      </div>`;
      }

      // Stats
      fetch(api + 'stats.php')
        .then(r => r.json()).then(j => renderStats(j.stats))
        .catch(_ => document.getElementById('stats-res').textContent = 'Error');

      function renderStats(s) {
        document.getElementById('stats-res').innerHTML = `<div class="stats-grid">
      ${[
            ['👥 Users', `Tot:${s.users.total}`, `Act:${s.users.active}`],
            ['🎮 Levels', `Tot:${s.levels.total}`, `Rt:${s.levels.rated}`],
            ['🔥 Featured', s.levels.featured],
            ['💥 Epic', s.levels.epic],
            ['🏆 Legendary', s.levels.legendary],
            ['💎 Mythic', s.levels.mythic],
            ['📅 Dailies', s.special.dailies],
            ['📆 Weeklies', s.special.weeklies],
            ['🛡 Gauntlets', s.special.gauntlets],
            ['📦 Map Packs', s.special.map_packs],
            ['📥 DL', `T:${s.downloads.total}`, `A:${s.downloads.average.toFixed(1)}`],
            ['🧱 Objs', `T:${s.objects.total}`, `A:${s.objects.average.toFixed(1)}`],
            ['❤️ Likes', `T:${s.likes.total}`, `A:${s.likes.average.toFixed(1)}`]
          ].map(c => `<div class="stat-card"><h3>${c[0]}</h3>${c.slice(1).map(x => `<p>${x}</p>`).join('')}</div>`).join('')}
    </div>`;
      }

      // Profile
      document.getElementById('btnProfile').onclick = () => {
        fetch(api + 'profile.php?accountID=' + v('profile-acc'))
          .then(r => r.json()).then(j => r('profile-res', j.profile || j))
          .catch(e => r('profile-res', { error: e }));
      };

      // AddSong
      document.getElementById('btnAddSong').onclick = () => {
        fetch(api + 'addSong.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: `name=${v('song-name')}&author=${v('song-author')}&download=${v('song-download')}`
        })
          .then(r => r.json()).then(j => r('addSong-res', j))
          .catch(e => r('addSong-res', { error: e }));
      };

      // MakePost
      document.getElementById('btnMakePost').onclick = () => {
        fetch(api + 'makePost.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: `auth=${v('post-auth')}&body=${encodeURIComponent(v('post-content'))}`
        })
          .then(r => r.json()).then(j => r('makePost-res', j))
          .catch(e => r('makePost-res', { error: e }));
      };

      // WhoRated
      document.getElementById('btnWhoRated').onclick = () => {
        fetch(api + 'whoRated.php?level=' + v('wr-level'))
          .then(r => r.json()).then(j => r('whoRated-res', j))
          .catch(e => r('whoRated-res', { error: e }));
      };
    });
  </script>

</body>

</html>