PGDMP  5    	                }            dbGestionJL    17.4    17.4 Z    0           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                           false            1           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                           false            2           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                           false            3           1262    16813    dbGestionJL    DATABASE     s   CREATE DATABASE "dbGestionJL" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'es-PE';
    DROP DATABASE "dbGestionJL";
                     postgres    false            �            1259    16814    administrador    TABLE     �   CREATE TABLE public.administrador (
    id integer NOT NULL,
    nombre character varying(100) NOT NULL,
    apellido character varying(100) NOT NULL,
    email character varying(100) NOT NULL,
    password text NOT NULL
);
 !   DROP TABLE public.administrador;
       public         heap r       postgres    false            �            1259    16819    administrador_id_seq    SEQUENCE     �   CREATE SEQUENCE public.administrador_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public.administrador_id_seq;
       public               postgres    false    217            4           0    0    administrador_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.administrador_id_seq OWNED BY public.administrador.id;
          public               postgres    false    218            �            1259    16820    calendario_incidencia    TABLE     �   CREATE TABLE public.calendario_incidencia (
    id integer NOT NULL,
    incidencia_id integer,
    fecha_programada date NOT NULL,
    observaciones text
);
 )   DROP TABLE public.calendario_incidencia;
       public         heap r       postgres    false            �            1259    16825    calendario_incidencia_id_seq    SEQUENCE     �   CREATE SEQUENCE public.calendario_incidencia_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 3   DROP SEQUENCE public.calendario_incidencia_id_seq;
       public               postgres    false    219            5           0    0    calendario_incidencia_id_seq    SEQUENCE OWNED BY     ]   ALTER SEQUENCE public.calendario_incidencia_id_seq OWNED BY public.calendario_incidencia.id;
          public               postgres    false    220            �            1259    16826    empleado    TABLE       CREATE TABLE public.empleado (
    id integer NOT NULL,
    dni character(8) NOT NULL,
    nombre character varying(100) NOT NULL,
    apellido character varying(100) NOT NULL,
    email character varying(100) NOT NULL,
    password text NOT NULL,
    creado_por integer
);
    DROP TABLE public.empleado;
       public         heap r       postgres    false            �            1259    16831    empleado_id_seq    SEQUENCE     �   CREATE SEQUENCE public.empleado_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.empleado_id_seq;
       public               postgres    false    221            6           0    0    empleado_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.empleado_id_seq OWNED BY public.empleado.id;
          public               postgres    false    222            �            1259    16832    empleado_token    TABLE     �   CREATE TABLE public.empleado_token (
    id integer NOT NULL,
    empleado_id integer,
    token text NOT NULL,
    creado timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);
 "   DROP TABLE public.empleado_token;
       public         heap r       postgres    false            �            1259    16838    empleado_token_id_seq    SEQUENCE     �   CREATE SEQUENCE public.empleado_token_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE public.empleado_token_id_seq;
       public               postgres    false    223            7           0    0    empleado_token_id_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE public.empleado_token_id_seq OWNED BY public.empleado_token.id;
          public               postgres    false    224            �            1259    16839    estado_incidencia    TABLE     @  CREATE TABLE public.estado_incidencia (
    id integer NOT NULL,
    nombre character varying(50) NOT NULL,
    CONSTRAINT estado_incidencia_nombre_check CHECK (((nombre)::text = ANY (ARRAY[('Pendiente'::character varying)::text, ('En Desarrollo'::character varying)::text, ('Terminado'::character varying)::text])))
);
 %   DROP TABLE public.estado_incidencia;
       public         heap r       postgres    false            �            1259    16843    estado_incidencia_id_seq    SEQUENCE     �   CREATE SEQUENCE public.estado_incidencia_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE public.estado_incidencia_id_seq;
       public               postgres    false    225            8           0    0    estado_incidencia_id_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE public.estado_incidencia_id_seq OWNED BY public.estado_incidencia.id;
          public               postgres    false    226            �            1259    16844    historial_estado    TABLE     �   CREATE TABLE public.historial_estado (
    id integer NOT NULL,
    incidencia_id integer,
    estado_id integer,
    fecha_cambio timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    empleado_id integer
);
 $   DROP TABLE public.historial_estado;
       public         heap r       postgres    false            �            1259    16848    historial_estado_id_seq    SEQUENCE     �   CREATE SEQUENCE public.historial_estado_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.historial_estado_id_seq;
       public               postgres    false    227            9           0    0    historial_estado_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.historial_estado_id_seq OWNED BY public.historial_estado.id;
          public               postgres    false    228            �            1259    16849 
   incidencia    TABLE     d  CREATE TABLE public.incidencia (
    id integer NOT NULL,
    descripcion text NOT NULL,
    foto bytea,
    latitud numeric(9,6) NOT NULL,
    longitud numeric(9,6) NOT NULL,
    direccion character varying(255),
    fecha_reporte timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    estado_id integer DEFAULT 1,
    asignado_a integer,
    atendido boolean DEFAULT false,
    prioridad_id integer,
    zona character varying(100),
    clasificada boolean DEFAULT false,
    clasificada_por integer,
    fecha_clasificacion timestamp without time zone,
    recursos_asignados text,
    tipo_id integer
);
    DROP TABLE public.incidencia;
       public         heap r       postgres    false            �            1259    16858    incidencia_id_seq    SEQUENCE     �   CREATE SEQUENCE public.incidencia_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.incidencia_id_seq;
       public               postgres    false    229            :           0    0    incidencia_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.incidencia_id_seq OWNED BY public.incidencia.id;
          public               postgres    false    230            �            1259    16859 	   log_admin    TABLE     �   CREATE TABLE public.log_admin (
    id integer NOT NULL,
    admin_id integer,
    accion text NOT NULL,
    fecha timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);
    DROP TABLE public.log_admin;
       public         heap r       postgres    false            �            1259    16865    log_admin_id_seq    SEQUENCE     �   CREATE SEQUENCE public.log_admin_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.log_admin_id_seq;
       public               postgres    false    231            ;           0    0    log_admin_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE public.log_admin_id_seq OWNED BY public.log_admin.id;
          public               postgres    false    232            �            1259    16866 	   prioridad    TABLE       CREATE TABLE public.prioridad (
    id integer NOT NULL,
    nivel character varying(50) NOT NULL,
    CONSTRAINT prioridad_nivel_check CHECK (((nivel)::text = ANY (ARRAY[('Alta'::character varying)::text, ('Media'::character varying)::text, ('Baja'::character varying)::text])))
);
    DROP TABLE public.prioridad;
       public         heap r       postgres    false            �            1259    16870    prioridad_id_seq    SEQUENCE     �   CREATE SEQUENCE public.prioridad_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.prioridad_id_seq;
       public               postgres    false    233            <           0    0    prioridad_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE public.prioridad_id_seq OWNED BY public.prioridad.id;
          public               postgres    false    234            �            1259    16960    tipo_incidencia    TABLE     m   CREATE TABLE public.tipo_incidencia (
    id integer NOT NULL,
    nombre character varying(100) NOT NULL
);
 #   DROP TABLE public.tipo_incidencia;
       public         heap r       postgres    false            �            1259    16959    tipo_incidencia_id_seq    SEQUENCE     �   CREATE SEQUENCE public.tipo_incidencia_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.tipo_incidencia_id_seq;
       public               postgres    false    236            =           0    0    tipo_incidencia_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE public.tipo_incidencia_id_seq OWNED BY public.tipo_incidencia.id;
          public               postgres    false    235            N           2604    16871    administrador id    DEFAULT     t   ALTER TABLE ONLY public.administrador ALTER COLUMN id SET DEFAULT nextval('public.administrador_id_seq'::regclass);
 ?   ALTER TABLE public.administrador ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    218    217            O           2604    16872    calendario_incidencia id    DEFAULT     �   ALTER TABLE ONLY public.calendario_incidencia ALTER COLUMN id SET DEFAULT nextval('public.calendario_incidencia_id_seq'::regclass);
 G   ALTER TABLE public.calendario_incidencia ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    220    219            P           2604    16873    empleado id    DEFAULT     j   ALTER TABLE ONLY public.empleado ALTER COLUMN id SET DEFAULT nextval('public.empleado_id_seq'::regclass);
 :   ALTER TABLE public.empleado ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    222    221            Q           2604    16874    empleado_token id    DEFAULT     v   ALTER TABLE ONLY public.empleado_token ALTER COLUMN id SET DEFAULT nextval('public.empleado_token_id_seq'::regclass);
 @   ALTER TABLE public.empleado_token ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    224    223            S           2604    16875    estado_incidencia id    DEFAULT     |   ALTER TABLE ONLY public.estado_incidencia ALTER COLUMN id SET DEFAULT nextval('public.estado_incidencia_id_seq'::regclass);
 C   ALTER TABLE public.estado_incidencia ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    226    225            T           2604    16876    historial_estado id    DEFAULT     z   ALTER TABLE ONLY public.historial_estado ALTER COLUMN id SET DEFAULT nextval('public.historial_estado_id_seq'::regclass);
 B   ALTER TABLE public.historial_estado ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    228    227            V           2604    16877    incidencia id    DEFAULT     n   ALTER TABLE ONLY public.incidencia ALTER COLUMN id SET DEFAULT nextval('public.incidencia_id_seq'::regclass);
 <   ALTER TABLE public.incidencia ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    230    229            [           2604    16878    log_admin id    DEFAULT     l   ALTER TABLE ONLY public.log_admin ALTER COLUMN id SET DEFAULT nextval('public.log_admin_id_seq'::regclass);
 ;   ALTER TABLE public.log_admin ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    232    231            ]           2604    16879    prioridad id    DEFAULT     l   ALTER TABLE ONLY public.prioridad ALTER COLUMN id SET DEFAULT nextval('public.prioridad_id_seq'::regclass);
 ;   ALTER TABLE public.prioridad ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    234    233            ^           2604    16963    tipo_incidencia id    DEFAULT     x   ALTER TABLE ONLY public.tipo_incidencia ALTER COLUMN id SET DEFAULT nextval('public.tipo_incidencia_id_seq'::regclass);
 A   ALTER TABLE public.tipo_incidencia ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    235    236    236                      0    16814    administrador 
   TABLE DATA           N   COPY public.administrador (id, nombre, apellido, email, password) FROM stdin;
    public               postgres    false    217   %q                 0    16820    calendario_incidencia 
   TABLE DATA           c   COPY public.calendario_incidencia (id, incidencia_id, fecha_programada, observaciones) FROM stdin;
    public               postgres    false    219   Ur                 0    16826    empleado 
   TABLE DATA           Z   COPY public.empleado (id, dni, nombre, apellido, email, password, creado_por) FROM stdin;
    public               postgres    false    221   rr                  0    16832    empleado_token 
   TABLE DATA           H   COPY public.empleado_token (id, empleado_id, token, creado) FROM stdin;
    public               postgres    false    223   t       "          0    16839    estado_incidencia 
   TABLE DATA           7   COPY public.estado_incidencia (id, nombre) FROM stdin;
    public               postgres    false    225   ,t       $          0    16844    historial_estado 
   TABLE DATA           c   COPY public.historial_estado (id, incidencia_id, estado_id, fecha_cambio, empleado_id) FROM stdin;
    public               postgres    false    227   qt       &          0    16849 
   incidencia 
   TABLE DATA           �   COPY public.incidencia (id, descripcion, foto, latitud, longitud, direccion, fecha_reporte, estado_id, asignado_a, atendido, prioridad_id, zona, clasificada, clasificada_por, fecha_clasificacion, recursos_asignados, tipo_id) FROM stdin;
    public               postgres    false    229   �t       (          0    16859 	   log_admin 
   TABLE DATA           @   COPY public.log_admin (id, admin_id, accion, fecha) FROM stdin;
    public               postgres    false    231   ku       *          0    16866 	   prioridad 
   TABLE DATA           .   COPY public.prioridad (id, nivel) FROM stdin;
    public               postgres    false    233   �u       -          0    16960    tipo_incidencia 
   TABLE DATA           5   COPY public.tipo_incidencia (id, nombre) FROM stdin;
    public               postgres    false    236   �u       >           0    0    administrador_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.administrador_id_seq', 6, true);
          public               postgres    false    218            ?           0    0    calendario_incidencia_id_seq    SEQUENCE SET     K   SELECT pg_catalog.setval('public.calendario_incidencia_id_seq', 1, false);
          public               postgres    false    220            @           0    0    empleado_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.empleado_id_seq', 5, true);
          public               postgres    false    222            A           0    0    empleado_token_id_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('public.empleado_token_id_seq', 1, false);
          public               postgres    false    224            B           0    0    estado_incidencia_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('public.estado_incidencia_id_seq', 1, false);
          public               postgres    false    226            C           0    0    historial_estado_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.historial_estado_id_seq', 1, false);
          public               postgres    false    228            D           0    0    incidencia_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.incidencia_id_seq', 1, true);
          public               postgres    false    230            E           0    0    log_admin_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.log_admin_id_seq', 1, false);
          public               postgres    false    232            F           0    0    prioridad_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.prioridad_id_seq', 1, false);
          public               postgres    false    234            G           0    0    tipo_incidencia_id_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('public.tipo_incidencia_id_seq', 4, true);
          public               postgres    false    235            b           2606    16881 %   administrador administrador_email_key 
   CONSTRAINT     a   ALTER TABLE ONLY public.administrador
    ADD CONSTRAINT administrador_email_key UNIQUE (email);
 O   ALTER TABLE ONLY public.administrador DROP CONSTRAINT administrador_email_key;
       public                 postgres    false    217            d           2606    16883     administrador administrador_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.administrador
    ADD CONSTRAINT administrador_pkey PRIMARY KEY (id);
 J   ALTER TABLE ONLY public.administrador DROP CONSTRAINT administrador_pkey;
       public                 postgres    false    217            f           2606    16885 0   calendario_incidencia calendario_incidencia_pkey 
   CONSTRAINT     n   ALTER TABLE ONLY public.calendario_incidencia
    ADD CONSTRAINT calendario_incidencia_pkey PRIMARY KEY (id);
 Z   ALTER TABLE ONLY public.calendario_incidencia DROP CONSTRAINT calendario_incidencia_pkey;
       public                 postgres    false    219            h           2606    16887    empleado empleado_dni_key 
   CONSTRAINT     S   ALTER TABLE ONLY public.empleado
    ADD CONSTRAINT empleado_dni_key UNIQUE (dni);
 C   ALTER TABLE ONLY public.empleado DROP CONSTRAINT empleado_dni_key;
       public                 postgres    false    221            j           2606    16889    empleado empleado_email_key 
   CONSTRAINT     W   ALTER TABLE ONLY public.empleado
    ADD CONSTRAINT empleado_email_key UNIQUE (email);
 E   ALTER TABLE ONLY public.empleado DROP CONSTRAINT empleado_email_key;
       public                 postgres    false    221            l           2606    16891    empleado empleado_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.empleado
    ADD CONSTRAINT empleado_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.empleado DROP CONSTRAINT empleado_pkey;
       public                 postgres    false    221            n           2606    16893 "   empleado_token empleado_token_pkey 
   CONSTRAINT     `   ALTER TABLE ONLY public.empleado_token
    ADD CONSTRAINT empleado_token_pkey PRIMARY KEY (id);
 L   ALTER TABLE ONLY public.empleado_token DROP CONSTRAINT empleado_token_pkey;
       public                 postgres    false    223            p           2606    16895 (   estado_incidencia estado_incidencia_pkey 
   CONSTRAINT     f   ALTER TABLE ONLY public.estado_incidencia
    ADD CONSTRAINT estado_incidencia_pkey PRIMARY KEY (id);
 R   ALTER TABLE ONLY public.estado_incidencia DROP CONSTRAINT estado_incidencia_pkey;
       public                 postgres    false    225            r           2606    16897 &   historial_estado historial_estado_pkey 
   CONSTRAINT     d   ALTER TABLE ONLY public.historial_estado
    ADD CONSTRAINT historial_estado_pkey PRIMARY KEY (id);
 P   ALTER TABLE ONLY public.historial_estado DROP CONSTRAINT historial_estado_pkey;
       public                 postgres    false    227            t           2606    16899    incidencia incidencia_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.incidencia
    ADD CONSTRAINT incidencia_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.incidencia DROP CONSTRAINT incidencia_pkey;
       public                 postgres    false    229            v           2606    16901    log_admin log_admin_pkey 
   CONSTRAINT     V   ALTER TABLE ONLY public.log_admin
    ADD CONSTRAINT log_admin_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.log_admin DROP CONSTRAINT log_admin_pkey;
       public                 postgres    false    231            x           2606    16903    prioridad prioridad_pkey 
   CONSTRAINT     V   ALTER TABLE ONLY public.prioridad
    ADD CONSTRAINT prioridad_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.prioridad DROP CONSTRAINT prioridad_pkey;
       public                 postgres    false    233            z           2606    16967 $   tipo_incidencia tipo_incidencia_pkey 
   CONSTRAINT     b   ALTER TABLE ONLY public.tipo_incidencia
    ADD CONSTRAINT tipo_incidencia_pkey PRIMARY KEY (id);
 N   ALTER TABLE ONLY public.tipo_incidencia DROP CONSTRAINT tipo_incidencia_pkey;
       public                 postgres    false    236            |           2606    16976 "   tipo_incidencia unique_nombre_tipo 
   CONSTRAINT     _   ALTER TABLE ONLY public.tipo_incidencia
    ADD CONSTRAINT unique_nombre_tipo UNIQUE (nombre);
 L   ALTER TABLE ONLY public.tipo_incidencia DROP CONSTRAINT unique_nombre_tipo;
       public                 postgres    false    236            }           2606    16904 >   calendario_incidencia calendario_incidencia_incidencia_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.calendario_incidencia
    ADD CONSTRAINT calendario_incidencia_incidencia_id_fkey FOREIGN KEY (incidencia_id) REFERENCES public.incidencia(id);
 h   ALTER TABLE ONLY public.calendario_incidencia DROP CONSTRAINT calendario_incidencia_incidencia_id_fkey;
       public               postgres    false    219    229    4724            ~           2606    16909 !   empleado empleado_creado_por_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.empleado
    ADD CONSTRAINT empleado_creado_por_fkey FOREIGN KEY (creado_por) REFERENCES public.administrador(id);
 K   ALTER TABLE ONLY public.empleado DROP CONSTRAINT empleado_creado_por_fkey;
       public               postgres    false    4708    221    217                       2606    16914 .   empleado_token empleado_token_empleado_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.empleado_token
    ADD CONSTRAINT empleado_token_empleado_id_fkey FOREIGN KEY (empleado_id) REFERENCES public.empleado(id);
 X   ALTER TABLE ONLY public.empleado_token DROP CONSTRAINT empleado_token_empleado_id_fkey;
       public               postgres    false    223    4716    221            �           2606    16919 2   historial_estado historial_estado_empleado_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.historial_estado
    ADD CONSTRAINT historial_estado_empleado_id_fkey FOREIGN KEY (empleado_id) REFERENCES public.empleado(id);
 \   ALTER TABLE ONLY public.historial_estado DROP CONSTRAINT historial_estado_empleado_id_fkey;
       public               postgres    false    227    4716    221            �           2606    16924 0   historial_estado historial_estado_estado_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.historial_estado
    ADD CONSTRAINT historial_estado_estado_id_fkey FOREIGN KEY (estado_id) REFERENCES public.estado_incidencia(id);
 Z   ALTER TABLE ONLY public.historial_estado DROP CONSTRAINT historial_estado_estado_id_fkey;
       public               postgres    false    4720    227    225            �           2606    16929 4   historial_estado historial_estado_incidencia_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.historial_estado
    ADD CONSTRAINT historial_estado_incidencia_id_fkey FOREIGN KEY (incidencia_id) REFERENCES public.incidencia(id);
 ^   ALTER TABLE ONLY public.historial_estado DROP CONSTRAINT historial_estado_incidencia_id_fkey;
       public               postgres    false    4724    229    227            �           2606    16934 %   incidencia incidencia_asignado_a_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.incidencia
    ADD CONSTRAINT incidencia_asignado_a_fkey FOREIGN KEY (asignado_a) REFERENCES public.empleado(id);
 O   ALTER TABLE ONLY public.incidencia DROP CONSTRAINT incidencia_asignado_a_fkey;
       public               postgres    false    221    229    4716            �           2606    16939 *   incidencia incidencia_clasificada_por_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.incidencia
    ADD CONSTRAINT incidencia_clasificada_por_fkey FOREIGN KEY (clasificada_por) REFERENCES public.administrador(id);
 T   ALTER TABLE ONLY public.incidencia DROP CONSTRAINT incidencia_clasificada_por_fkey;
       public               postgres    false    4708    217    229            �           2606    16944 $   incidencia incidencia_estado_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.incidencia
    ADD CONSTRAINT incidencia_estado_id_fkey FOREIGN KEY (estado_id) REFERENCES public.estado_incidencia(id);
 N   ALTER TABLE ONLY public.incidencia DROP CONSTRAINT incidencia_estado_id_fkey;
       public               postgres    false    225    229    4720            �           2606    16949 '   incidencia incidencia_prioridad_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.incidencia
    ADD CONSTRAINT incidencia_prioridad_id_fkey FOREIGN KEY (prioridad_id) REFERENCES public.prioridad(id);
 Q   ALTER TABLE ONLY public.incidencia DROP CONSTRAINT incidencia_prioridad_id_fkey;
       public               postgres    false    4728    233    229            �           2606    16968 "   incidencia incidencia_tipo_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.incidencia
    ADD CONSTRAINT incidencia_tipo_id_fkey FOREIGN KEY (tipo_id) REFERENCES public.tipo_incidencia(id);
 L   ALTER TABLE ONLY public.incidencia DROP CONSTRAINT incidencia_tipo_id_fkey;
       public               postgres    false    229    236    4730            �           2606    16954 !   log_admin log_admin_admin_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.log_admin
    ADD CONSTRAINT log_admin_admin_id_fkey FOREIGN KEY (admin_id) REFERENCES public.administrador(id);
 K   ALTER TABLE ONLY public.log_admin DROP CONSTRAINT log_admin_admin_id_fkey;
       public               postgres    false    231    4708    217                  x�m�Kr�0 @���#٩�� ��N71�O	��'ުg���Mg:S��{�k�1`��#_�,!�����Һ3e�!y��S��[a��3"�K�U_�k"'qu.۪��+M��4Ɋ
"i������V965l�ic<�T�#�<'o����hǴ8-|�R��X+ի��� Jה
Ȓ6�ל�/�+۽���9�S�C���ct���v�
���h@K�0��HK�=E6�Hj@�������ɱ���]��~6خ�0\d���,�.��4�t	���%I�b�x            x������ � �         �  x�m��r�@�u���K�.tP��l�{#6�ѷ�g��1���"�u�:痀���el��ȀI������T�S��B�r�����8�M���"=+���KS�s��v�2"W��l9�Az�{Y���0x�f MUd(�`�p�6���S��}�Is�olBt��Ԕ�l�Q����*jy��Z[մdZ8�m��W���OC�UC:p9@��@����1��BK"CͮT��ԋ�;�F�d�ւ�#����*��kSL��`� �DCԿ�ƾ6+���ߝnwZ��BS+��[q��1�M��_NtL���݉�x1;̝�?�g!�ai� ��#IP�?�f�ѮNmLfJ/B�Z�|a���y�D��_��s֚p�"��k�(|�y@o�l6�y��"             x������ � �      "   5   x�3�H�K�L�+I�2�t�SpI-N,*�����2�I-���KL������ G�      $      x������ � �      &   �   x�]�An� E��\ ��̮��z�lP��J3�QG��l�X�����͓?�;����z�?���K����z��������s)��p��U�D��`$�и�QAX�f6���SX5CQY;��6�H���w[�j�d�%�Vۗż�hK��#K��'n$L9�!���r����b�<�<��t
���m��'��qhX�a� Q�Kn      (      x������ � �      *      x������ � �      -   h   x�˱�@F��<�'@
d� �R��K��;G�0XZZ#�~�{�˦���
ӂ�ZY�a{����9��8i���[�l���T�gzk芻�X�����v�#�     