import React from 'react'
import React, {useState} from 'react'

function Signup() {
    const [values, setValues] = useState({
        name: '',
        email: '',
        password: ''
    })
    const handleChange = (event) =>{
        setValues({...values, [event.target.name]: [event.target.value]})
    }
    const handleSubmit = (event) =>{
        event.preventDefault();
        axios.post('http://localhost:8800/signup', {values})
        .then(res => console.log("Registered Successfully!"))
        .catch(err => console.log(err));
    }
    return (
        <div>
            <h2>SignUp</h2>
            <form onSubmit={handleSubmit}>
                <div className='name'>
                    <label><strong>Name</strong></label>
                <input type="text" placeholder='Enter Name' name='name'
                onChange={handleChange}/>
                </div>
                <div className='email'>
                    <label><strong>Email</strong></label>
                <input type="email" placeholder='Enter Email' name='email'/>
                </div>
                <div className='password'>
                    <label><strong>Password</strong></label>
                <input type="password" placeholder='Enter Password' name='email'/>
                </div>
                <button type='submit'>Signup</button>
                <p>You are afree to our terms and policies</p>
            </form>
        </div>
    )
}

export default Signup
