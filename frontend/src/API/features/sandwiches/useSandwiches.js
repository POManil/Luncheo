import { useQueryClient, useQuery } from "@tanstack/react-query";

import { useAxios } from "../../config/AxiosContext";
import { fetchSandwiches } from "./fetchSandwiches";

export const useSandwiches = () => {
  const client = useAxios();
  const queryClient = useQueryClient();
  
  return useQuery({
    queryKey: ['fetchSandwiches'],
    queryFn: () => fetchSandwiches(client)
  }, queryClient);
}
