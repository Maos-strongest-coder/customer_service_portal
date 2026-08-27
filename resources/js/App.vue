<template>
    <nav>
        <router-link :to="{name: 'dashboard'}">Dashboard</router-link>
        |
        <router-link :to="{name: 'login'}">Login</router-link>
        |
        <router-link :to="{name: 'overview'}">Overview</router-link>
    </nav>

    <router-view></router-view>
</template>
