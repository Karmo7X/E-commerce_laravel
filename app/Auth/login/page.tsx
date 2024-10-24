'use client'
import MainButton from "@/components/Buttons/Main_button";
import React, { useState } from "react";

const Page = () => {
  interface formdatatype{
    email?: string;
        password?: string;
   
}
interface ValidationErrors {
  email?: string;
  password?: string;
   
  }
  const [formdata,setFormdata]=useState<formdatatype>({
   
    email:'',
    password:'',
  
    })

    const handleChange=(e:React.ChangeEvent<HTMLInputElement>)=>{
      const{name,value}=e.target
      setFormdata({
        ...formdata,
        [name]:value
      })
    }
    const validate =(value:formdatatype)=>{
      const errors: ValidationErrors = {};
      if (!value.email) {
        errors.email = 'Email is required';
      }
    
      if (!value.password) {
        errors.password = 'Password is required';
      }
    
    
    
      return errors;
  }
  return (
    <div className="min-h-screen">
      <div className="flex min-h-full flex-1 flex-col w-full justify-center px-6 py-12 gap-7 lg:px-8">
        <div className="sm:mx-auto sm:w-full sm:max-w-lg ">
          <h3 className="-m-1.5 p-1.5 text-center font-bold text-xl xl:text-2xl 2xl:text-3xl ">
            Ventrova
          </h3>
          <p className="mt-10 text-center text-lg w-full leading-9 tracking-tight text-gray-900">
            Ready to shop? Log in to explore new arrivals and member-only perks!
          </p>
        </div>

        <div className="mt-10 sm:mx-auto sm:w-full sm:max-w-lg">
          <form action="#" method="POST" className="space-y-6">
            <div>
              <label
                htmlFor="email"
                className="block text-sm font-medium leading-6 text-gray-900"
              >
                Email address
              </label>
              <div className="mt-2">
                <input
                  id="email"
                  name="email"
                  type="email"
                  required
                  onChange={(e)=>handleChange(e)}
                  autoComplete="email"
                  className="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                />
              </div>
            </div>

            <div>
              <div className="flex items-center justify-between">
                <label
                  htmlFor="password"
                  className="block text-sm font-medium leading-6 text-gray-900"
                >
                  Password
                </label>
                <div className="text-sm">
                  <a
                    href="#"
                    className="font-semibold text-black_color hover:text-black_color"
                  >
                    Forgot password?
                  </a>
                </div>
              </div>
              <div className="mt-2">
                <input
                  id="password"
                  name="password"
                  type="password"
                  onChange={(e)=>handleChange(e)}
                  required
                  autoComplete="current-password"
                  className="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                />
              </div>
            </div>

            <div>
              <MainButton
                title="Login"
                icon={""}
                classes="text-center bg-black_color w-full text-white py-2 "
              />
            </div>
          </form>

          <p className="mt-10 text-center text-sm text-gray-500">
            Ready to join our community?{" "}
            <a
              href="/Auth/register"
              className="font-semibold leading-6 text-black_color hover:text-black_color"
            >
              Sign up today and start enjoying exclusive benefits!
            </a>
          </p>
        </div>
      </div>
    </div>
  );
};

export default Page;
