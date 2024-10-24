import { useQueryClient, useQuery } from "@tanstack/react-query";

import { useAxios } from "../../config/AxiosContext";
import { fetchOrders } from "./fetchOrders";

export const useOrders = ({param}) => {
  const client = useAxios();
  const queryClient = useQueryClient();

  const key = param ?? 'all';
  
  return useQuery({
    queryKey: ['orders', key],
    queryFn: () => fetchOrders(client, key)
  }, queryClient);
}
