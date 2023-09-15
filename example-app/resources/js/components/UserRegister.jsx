import React, { useState } from "react";

export default function UserRegister(){
    const [register, setRegister] = useState({
        name : '',
        email : '',
        password : ''
    });
    function inputRegister(event){
        setRegister(formData=>({
            ...formData,
            [event.target.name] : event.target.value
        }))
    }
    function sendData(event){
        event.preventDefault();
        const data = {
            name : register.name,
            email : register.email,
            password : register.password,
        }
        axios.post("http://127.0.0.1:8000/api/add-user", data).then(response=>{
        console.log(response)
        })
    }
    return(
        <div>
            <form onSubmit={sendData}>
            <input 
                type="text" 
                name="name" 
                id="name" 
                value={register.name}
                onChange={inputRegister}
            />
            <input 
                type="email" 
                name="email" 
                id="name" 
                value={register.email}
                onChange={inputRegister}
            />
            <input 
                type="password" 
                name="password" 
                id="password" 
                value={register.password}
                onChange={inputRegister}
            />
            <button>valider</button>
            </form>
        </div>
    )
}