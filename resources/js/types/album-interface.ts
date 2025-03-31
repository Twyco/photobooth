import { AlbumAccessCodeInterface } from '@/types/album-access-code-interface';

export interface UserAlbum {
  uuid: string;
  title: string;
  description: string;
  cover: string;
  eventDate: string;
}
export interface UserAlbumWithImages extends UserAlbum {
  images: string[];
}

export interface AdminAlbumInterface extends UserAlbumWithImages {
  id: number;
  accessCodes: AlbumAccessCodeInterface[];
  qrCode: string;
}
