import React, { FC } from 'react';


    
interface MainButtonProps {
    title: string;     // The title of the button
    icon?: React.ReactNode; // Optional icon, can be any React node
    classes?: string;  // Optional additional CSS classes
}  

const MainButton:FC<MainButtonProps> = ({title,icon,classes}) => {

    
    return (
        <>
          <button className={`flex items-center justify-center ${classes}`}>
            {title}
            {icon}
          </button>
        </>
    );
}

export default MainButton;
