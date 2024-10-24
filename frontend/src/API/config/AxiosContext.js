import { createContext, useContext } from "react";
import axios from "axios";

export const AxiosContext = createContext(axios);

export const useAxios = () => useContext(AxiosContext);