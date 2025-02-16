export interface TableHeaderInterface {
  key: string;
  title: string;
  objectKey?: string;
  arrayKey?: string;
  isDate?: boolean;
  type?: TableHeaderType;
}

export type TableHeaderType =
  | 'object'
  | 'array'
  | 'objectArray';
