
import type { Metadata } from "next";
import localFont from "next/font/local";
import "./globals.scss";
import Navbar from "@/components/Navbar/Navbar";
import { usePathname } from "next/navigation"; // Import the usePathname hook
import Footer from "@/components/Footer/Footer";
import StoreProvider from "./StoreProvider";

const geistSans = localFont({
  src: "./fonts/GeistVF.woff",
  variable: "--font-geist-sans",
  weight: "100 900",
});
const geistMono = localFont({
  src: "./fonts/GeistMonoVF.woff",
  variable: "--font-geist-mono",
  weight: "100 900",
});

export const metadata: Metadata = {
  title: "Ventrova | Shop the Latest Deals Online - Affordable & Premium Products",
  description: "Ventrova is your one-stop e-commerce store for premium products, unbeatable prices, and a seamless shopping experience. Explore fashion, tech, home goods, and more.",
  keywords: "e-commerce, online shopping, premium products, affordable deals, fashion, technology, home goods, best prices, shop now, Ventrova store",
  robots: "index, follow", // Ensures search engines index and follow the links on your page.
  openGraph: {
    title: "Ventrova – Shop the Latest Deals & Premium Products Online",
    description: "Discover top-quality products at Ventrova. Shop the best deals in fashion, technology, home goods, and more with a seamless online shopping experience.",
    url: "https://ventrova.com", // Replace with your domain
    images: [
      {
        url: "https://ventrova.com/images/logo.png", // Replace with your actual image URL
        width: 800,
        height: 600,
        alt: "Ventrova e-commerce store",
      },
    ],
  },

};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
    
  return (
    <html lang="en">
      <StoreProvider>
      <body
        className={`${geistSans.variable} ${geistMono.variable} antialiased `}
      >
        <Navbar/>
        {children}
        <Footer/>
      </body>
      </StoreProvider>
    </html>
  );
}
