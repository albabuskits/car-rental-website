import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  { path: '/', name: 'Home', component: () => import('@/views/HomePage.vue') },
  { path: '/login', name: 'Login', component: () => import('@/views/LoginPage.vue') },
  { path: '/cars', name: 'CarsListing', component: () => import('@/views/CarsListing.vue') },
  { path: '/cars/:id', name: 'CarDetails', component: () => import('@/views/CarDetails.vue') },
  { path: '/booking', name: 'Booking', component: () => import('@/views/BookingPage.vue') },
  { path: '/about-us', name: 'AboutUs', component: () => import('@/views/AboutUs.vue') },
  { path: '/contact-us', name: 'ContactUs', component: () => import('@/views/ContactUs.vue') },
  // Admin routes are handled by Laravel Livewire, not Vue
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior() {
    return { top: 0 }
  }
})

export default router