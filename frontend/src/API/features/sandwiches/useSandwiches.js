import { useQueryClient, useQuery } from "@tanstack/react-query";

import { useAxios } from "../../config/AxiosContext";

/**
 * Fetch a list of all sandwiches.
 * @param {object} client  
 * @returns {Array<object>}
 */
const fetchSandwiches = async (client) => {
  try {
    const sandwiches = await client.get('/sandwich/all');
    return sandwiches;
  } catch (error) {
    console.error(error);
    throw error;
  }
}

export const useSandwiches = () => {
  const client = useAxios();
  const queryClient = useQueryClient();
  
  return useQuery({
    queryKey: ['fetchSandwiches'],
    queryFn: () => fetchSandwiches(client)
  }, queryClient);
}
