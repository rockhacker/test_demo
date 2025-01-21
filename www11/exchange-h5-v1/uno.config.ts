import { defineConfig } from "unocss";

import presetUno from "@unocss/preset-uno";
import presetRemToPx from "@unocss/preset-rem-to-px";

export default defineConfig({
  theme: {
    colors: {
      up: "#2fdab0",
      down: "#f84f4f",
      main: "#9FEF4E",
    },
  },
  presets: [
    presetUno(),
    presetRemToPx({
      baseFontSize: 4,
    }),
    {
      name: "to-important",
      postprocess: (util) => {
        util.entries.forEach((i) => {
          const value = i[1];
          if (typeof value === "string") i[1] += " !important";
        });
      },
    },
  ],
});
