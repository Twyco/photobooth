export interface User {
  name: string;
  email: string;
  is_admin: boolean;
}
export interface NavMenuItem {
  route: string;
  label: string;
  active: boolean;
  button: boolean;
}

export type PageProps<
  T extends Record<string, unknown> = Record<string, unknown>
> = T & {
  auth: {
    user: User;
  };
  menu: {
    items: NavMenuItem[];
  }
};
