import { createContext, useState } from "react";

export const LoginContext = createContext(null);

const ContextProvider = ({children}) => {

    const [user, setUser] = useState({});
    const [token, setToken] = useState(localStorage.getItem('TOKEN'));

    const _setToken = (token) => {
        setToken(token);
        if (token){
            localStorage.setItem('TOKEN', token);
        }
        else{
            localStorage.removeItem('TOKEN');
        }
    }

    return (
        <LoginContext.Provider value = {{
            _setToken, user, token
        }}>
            {children}
        </LoginContext.Provider>
    )
}

export default ContextProvider;