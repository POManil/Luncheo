import { useQueryClient, useQuery } from "@tanstack/react-query";

import { useAxios } from "../../config/AxiosContext";
import { fetchUsers } from "./fetchUsers";

export const useUsers = ({param}) => {
  const client = useAxios();
  const queryClient = useQueryClient();

  const key = param ?? 'all';
  
  return useQuery({
    queryKey: ['users', key],
    queryFn: () => fetchUsers(client, key)
  }, queryClient);
}
