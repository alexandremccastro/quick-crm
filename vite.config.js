import path from 'node:path'
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import { fileURLToPath, URL } from 'node:url'

export default defineConfig({
  build: {
    lib: {
      entry: path.resolve(__dirname, 'resources/js/index.js'),
      name: 'Entry',
      fileName: 'index',
      formats: ['cjs'],
    },
    rollupOptions: {
      input: path.resolve(__dirname, 'resources/js/index.js'),
      output: {
        format: 'cjs',
      },
      external: {
        source: 'vue/dist/vue.esm-bundler',
      },
    },
    outDir: './public/js',
  },
  plugins: [vue()],
  define: {
    'process.env': process.env,
  },
  resolve: {
    extensions: ['js'],
    alias: {
      '@': fileURLToPath(new URL('./resources/js', import.meta.url)),
      vue: 'vue/dist/vue.esm-bundler.js',
    },
  },
})
