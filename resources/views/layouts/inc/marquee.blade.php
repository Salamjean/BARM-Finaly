<table width="100%" border="0" cellpadding="0" cellspacing="0">
    @if ($infos->isEmpty())
        <tr style="display: none"></tr>
    @else
        <tr>
            <th style="background-color:#001B63; color:rgb(255, 255, 255); width:10%">&nbsp;<i
                    class="fas fa-bullhorn">&nbsp;</i>Informations : </th>
            <th bgcolor="#F1EFEF" scope="col" class="auto-style4">
                <marquee direction="left" scrollamount="6" style="background-color:#fafd2c; color:  ;">
                    @foreach ($infos as $key => $info)
                        <span>
                            <span class="text-primary text-decoration-underline">{{ $info->title }}</span> : {{ $info->contenu }} &nbsp;&bull;&nbsp;
                            @if (count($infos) != $key + 1)
                                <span style="margin-right:2px;"></span>
                            @endif
                        </span>
                    @endforeach
                </marquee>
            </th>
        </tr>
    @endif
</table>
