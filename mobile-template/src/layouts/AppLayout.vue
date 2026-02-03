<template>
  <div class="app-shell">
    <nav class="navbar navbar-light bg-light border-bottom">
      <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">Mobile App</span>
      </div>
    </nav>

    <main class="container-fluid py-3">
      <router-view />
    </main>

    <nav class="navbar fixed-bottom navbar-light bg-light border-top">
      <div class="container-fluid d-flex justify-content-around">
        <RouterLink class="nav-link" to="/">Index</RouterLink>
        <RouterLink class="nav-link" to="/view">View</RouterLink>
        <RouterLink class="nav-link" to="/edit">Edit</RouterLink>
      </div>
    </nav>
  </div>
</template>

<style>
.app-shell {
  padding-bottom: env(safe-area-inset-bottom);
}
</style>