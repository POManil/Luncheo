import axios from 'axios';
import { useMemo } from 'react';
import { AxiosContext } from './AxiosContext';
import { BASE_URL } from '../../helpers/constants';
import PropTypes from 'prop-types';

export const AxiosProvider = ({ children }) => {
  const token = null;

  const client = useMemo(() => {
    const headers = token != null
      ? { 'Authorization': 'Bearer ' + token }
      : {}

    const instance = axios.create({
      baseURL: BASE_URL,
      headers
    });

    instance.interceptors.response.use(
      response => {
        // console.log("axios response", response.config.url)
        return response.data
      },
      error => {
        // console.error('url ayant généré l\'erreur:', error.config.url);
        // On a un message d'erreur spécifique de l'API
        if("response" in error) {
          if(error.response.status === 500) {
            return Promise.reject("Une erreur imprévue est survenue.");
          } else if(error.response.data) {
            return Promise.reject("Les valeurs saisies sont invalides.");
          } else {
            return Promise.reject(error.response.data);
          }
        // Network error
        } else if(error.code === 'ERR_NETWORK') {
          return Promise.reject("Erreur du réseau ou provenant du serveur. Veuillez réessayer plus tard.");
        } else if(error.code === 'ECONNABORTED') {
          return Promise.reject("L'activité du serveur semble interrompue. Veuillez réessayer plus tard.");
        }
        // Erreur non-spécifique ou imprévue
        // console.error(error);
        return Promise.reject(error);
      }
    );

    return instance;
  }, [token]);

  return (
    <AxiosContext.Provider value={client}>{children}</AxiosContext.Provider>
  );
}

AxiosProvider.propTypes = { 
  children: PropTypes.element
};