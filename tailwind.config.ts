import type { Config } from "tailwindcss";

const config: Config = {
  content: [
    "./pages/**/*.{js,ts,jsx,tsx,mdx}",
    "./components/**/*.{js,ts,jsx,tsx,mdx}",
    "./app/**/*.{js,ts,jsx,tsx,mdx}",
  ],
  theme: {
    extend: {
      colors: {
        black_color: '#010101',
        offWhite_color: '#f2f0ea',
        yellow_color: '#edcf5d',
        gray_color: '#a4a4a4',
      },
    },
  },
  plugins: [],
};
export default config;
