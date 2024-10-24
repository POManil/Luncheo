import { useQueryClient, useQuery } from "@tanstack/react-query";

import { useAxios } from "../../config/AxiosContext";

/**
 * Fetch a list of users based on a param. Defaults to `all`.
 * @param {object} client 
 * @param {number | 'all'} [param] 
 * @returns {Array<object>}
 */
const fetchUsers = async (client, param) => {
  try {
    const users = await client.get('/user/' + param);
    return users;
  } catch (error) {
    console.error(error);
    throw error;
  }
}

export const useUsers = ({param}) => {
  const client = useAxios();
  const queryClient = useQueryClient();

  const key = param ?? 'all';
  
  return useQuery({
    queryKey: ['users', key],
    queryFn: () => fetchUsers(client, key)
  }, queryClient);
}
