import { resolve } from 'path'
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import { fileURLToPath, URL } from 'node:url'

export default defineConfig({
  plugins: [
    vue()
  ],
  resolve: {
      alias: {
        '@': fileURLToPath(new URL('blocks/post-filter/app/vue/src', import.meta.url))
      }
    },
  build: {
    minify: 'terser',
    terserOptions: {
      keep_fnames: true
    },

    polyfillModulePreload: false,
    rollupOptions: {
      input: {
        public: resolve(__dirname, 'public.html'),
        admin: resolve(__dirname, 'admin.html'),
        vue: resolve(__dirname,'blocks/post-filter/vue.html')
      },
    },
  },
})