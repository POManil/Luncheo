import { useQueryClient, useQuery } from "@tanstack/react-query";

import { useAxios } from "../../config/AxiosContext";

/**
 * Fetch a list of orders based on a param. Defaults to `all`.
 * @param {object} client 
 * @param {number | 'all'} [param] 
 * @returns {Array<object>}
 */
const fetchOrders = async (client, param) => {
  try {
    const res = await client.get('order/' + param);
    return res
  } catch (error) {
    console.error(error);
    throw error;
  }
}

export const useOrders = ({param}) => {
  const client = useAxios();
  const queryClient = useQueryClient();
  
  return useQuery({
    queryKey: ['orders'],
    queryFn: () => fetchOrders(client, param ?? 'all')
  }, queryClient);
}
