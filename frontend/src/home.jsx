import React from "react";
import { useNavigate } from 'react-router-dom';



const Home = () => {
    const navigate = useNavigate();
    const navigatehome = () =>{
        navigate('/Home')
    }
    const navigateSignup = () => {
        navigate('/SignUp')
    }

    return (
        <div>
                <a onClick={navigateSignup}>SIGNUP</a>
        </div>

    )


}

export default Home