import { createRouter, createWebHistory } from 'vue-router'
import AppLayout from '@/layouts/AppLayout.vue'

export default createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            component: AppLayout,
            children: [
                { path: '', name: 'index', component: () => import('@/views/Index.vue') },
                { path: 'view', name: 'view', component: () => import('@/views/View.vue') },
                { path: 'edit', name: 'edit', component: () => import('@/views/Edit.vue') }
            ]
        }
    ]
})