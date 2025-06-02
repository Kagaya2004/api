import { useState } from "react";

const useValidator = (initialModel, errorModel, validationRules) => {
    const [model, setModel] = useState(initialModel);
    const [error, setError] = useState(errorModel);
    const handleChangeField = (e) => {
        const {name, value} = e.target;
        setModel((prev) => ({
            ...prev, [name] : value
        }));
        
        console.log(model);
    }

    const hasErrors = (erros) => {
        return Object.values(erros).some(value => value === true);
    }

    const validateAll = () => {
        let erros = {};
        Object.keys(validationRules).forEach((field) => {
            const validationFunction = validationRules[field];
            const value = model[field];

            erros[`${field}Mensagem`] = validationFunction(value, model);
            erros[field]=!!(erros[`${field}Mensagem`] && erros[`${field}Mensagem`].length > 0);

            console.log(erros);
            console.log(field);
            console.log(validationFunction);
            console.log(model);
        })
        setError(erros);
        console.log(erros);
        return erros;
    }

    const formValid = () => {
        const errors = validateAll();
        setError(erros);
        return !hasErrors(erros);
    }


    return {
        model,
        setModel,
        error,
        setError,
        handleChangeField,
        formValid,
    }
}

export default useValidator;