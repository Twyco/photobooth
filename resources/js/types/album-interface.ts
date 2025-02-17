import { AlbumAccessCodeInterface } from '@/types/album-access-code-interface';

export interface UserAlbumInterface {
  uuid: string;
  title: string;
  description: string;
  eventDate: string;
}

export interface AdminAlbumInterface extends UserAlbumInterface {
  id: number;
  accessCodes: AlbumAccessCodeInterface[];
}
