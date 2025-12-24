<script setup>
function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();
    console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
    console.log('Name: ' + profile.getName());
    console.log('Image URL: ' + profile.getImageUrl());
    console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
}

</script>

<template>
<p class="text-3xl font-bold text-green-500">This is vue setup for laravel with vue vite inertia and quasar</p>
    <q-bar aria-label="asda"/>

    <div class="g-signin2" data-onsuccess="onSignIn"></div>

    <a href="{{ route('google.redirect') }}" class="btn btn-primary"> Login with Google </a>
</template>

<style scoped>

</style>
