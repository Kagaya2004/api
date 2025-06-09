import React, { Fragment, useEffect, useState } from 'react'
import axiosClient from '../../axiosClient';
import { Link, useNavigate, useParams } from 'react-router-dom';
import { useValidarDadosUser } from '../../rules/UserValidationRules';
import Input from '../../components/input/Input';

function UserFormUpdate() {
    const navigate = useNavigate();

    const {
        model,
        setModel,
        error,
        formValid,
        handleChangeField,
        handleBlurField
    } = useValidarDadosUser();

    const { id } = useParams();

    if (id) {
        useEffect(() => {
            axiosClient.get(`/user/show/${id}`)
                .then(({ data }) => {
                    setModel(data.data);
                    //console.log(data.data);
                }).catch((error) => {
                    console.log(error);
                })
        }, [id]);
    }



    // Função do tipo Anônima
    const onSubmit = (e) => {
        e.preventDefault();
        if (formValid) {
            axiosClient.put(`/user/update/${id}`, model)
                .then(() => {
                    console.log('Usuário alterado com sucesso');
                    navigate('/user/index')
                }).catch((error) => {
                    console.log(error);
                })
        }

    }

    console.log(model)
    return (
        <Fragment>
            <div className="display">
                <div className="card animated fadeinDown">
                    {model.id && <h1>Alteração de Usuário: {model.name}</h1>}
                    <form onSubmit={(e) => onSubmit(e)}>
                        <div className='p-20'>
                            <Input
                                id="name"
                                type="text"
                                value={model.name}
                                placeholder="Nome"
                                handleChangeField={handleChangeField}
                                handleBlurField={handleBlurField}
                                error={error.name}
                                mensagem={error.nameMensagem}
                            />
                        </div>
                        <div className='p-20'>
                            <Input
                                id="email"
                                type="text"
                                value={model.email}
                                placeholder="Email"
                                handleChangeField={handleChangeField}
                                handleBlurField={handleBlurField}
                                error={error.email}
                                mensagem={error.emailMensagem}
                            />
                        </div>
                        <div className='p-20'>
                            <Input
                            id="password"
                            type="text"
                            value={model.password}
                            placeholder="Senha"
                            handleChangeField={handleChangeField}
                            handleBlurField={handleBlurField}
                            error={error.password}
                            mensagem={error.passwordMensagem}
                        />
                        </div>
                        <button className="btn btn-edit">Salvar</button>
                        <Link
                            type='button'
                            className='btn btn-cancel'
                            to='/user/index'>
                            Cancelar
                        </Link>
                    </form>
                </div>


            </div>
        </Fragment>

        /*
        OU
        Div
        <div>

        </div>

        OU

        Fragmento Vazio
        <>
        </>
        */
    )
}

export default UserFormUpdate