import path from "path";
import { defineConfig } from "vite";
import components from 'unplugin-vue-components/vite'
import autoImport from "unplugin-auto-import/vite";
import unocss from "unocss/vite";
import vue from "@vitejs/plugin-vue";
import pxtovw from "postcss-px-to-viewport";
import { VantResolver } from 'unplugin-vue-components/resolvers';
import { createSvgIconsPlugin } from "vite-plugin-svg-icons";
import vueSetupExtend from 'vite-plugin-vue-setup-extend-plus'

// https://vitejs.dev/config/
export default defineConfig({
  base: "",
  resolve: {
    alias: [
      { find: "@", replacement: path.resolve(__dirname, "src") },
      { find: "@images", replacement: path.resolve(__dirname, "src/assets/images") },
      { find: "vue-i18n", replacement: "vue-i18n/dist/vue-i18n.cjs.js" },
    ],
  },
  css: {
    postcss: {
      plugins: [
        pxtovw({
          viewportWidth: 375,
          viewportUnit: "vw",
        }),
      ],
    },
  },
  server: {
    host: '0.0.0.0',
    port: 3000
  },
  plugins: [
    vue(),
    vueSetupExtend(),
    autoImport({
      imports: ["vue", "@vueuse/core", "vue-router", "pinia"],
    }),
    components({
      resolvers: [VantResolver()]
    }),
    unocss(),
    createSvgIconsPlugin({
      // 指定需要缓存的图标文件夹
      iconDirs: [path.resolve(process.cwd(), "src/assets/svg/")],
      // 指定symbolId格式
      symbolId: "icon-[dir]-[name]",
    }),
  ],
  build: {
    rollupOptions: {
      output: {
        entryFileNames: `assets/entry/[name][hash].js`,
        chunkFileNames: `assets/chunk/[name][hash].js`,
        assetFileNames: `assets/file/[name][hash].[ext]`,
        manualChunks(id) {
          if (id.includes("vant")) {
            return "ui";
          }
          if (id.includes("vue-router")) {
            return "router";
          }
          if (id.includes("vue-i18n")) {
            return "i18n";
          }
          if (id.includes("axios")) {
            return "request";
          }
          if (id.includes("klinecharts")) {
            return "chart";
          }
          if (id.includes("node_modules")) {
            return "vendor"; //代码分割为第三方包
          }
          // if (id.includes("views")) {
          //   return "views"; //代码分割为第三方包
          // }
        },
      },
    },
  }
});
