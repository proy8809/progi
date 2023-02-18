/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import '../sass/app.scss'
import { createApp } from 'vue';

import app from './components/App.vue';
createApp(app).mount("#app");
