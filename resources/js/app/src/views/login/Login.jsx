import { useState } from "react";
import { Link } from "react-router-dom";


export default function Login(){

    const [message, setMessage] = useState(null);

    return (
        <div className="login-signup-form animated fadeInDown">
            <div className="form">
                <form>
                    <h1 className="title p-20">Acesso ao Sistema com sua conta</h1>
                    {
                        message &&
                        <div className='alert'>
                            <p>{message}</p>
                        </div>
                    }
                    <input type="text" placeholder="E-mail" classname='p-20'/>
                    <input type="password" placeholder="Senha" classname='p-20'/>
                    <button className='btn btn-block p-20'>Login</button>
                    <p className='message'>Não está registrado</p><Link to="/register">Criar nova conta</Link>
                </form>
            </div>
        </div>
    );
}