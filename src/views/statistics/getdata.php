<?php
    if(isset($_GET['timestart'])&&isset($_GET['timeend'])){
        $timestartstr = $_GET['timestart'];
        $timeendstr = $_GET['timeend'];
        $timestart = strtotime($timestartstr);
        $timeend = strtotime($timeendstr);
        $totalmoney=0;
        $numoftrans=0;
        $numofproduct=0;
        
        foreach($transactions as $transaction){
            $time = strtotime($transaction->getCreated()->format('Y-m-d'));
            if($time>=$timestart&&$time<=$timeend){
                $numoftrans++;
                $total=0;
                foreach ($transaction->getItems() as $item) : 
                    $total += $item->getProduct()->getPrice() * $item->getQuantity() ;
                    $numofproduct+=$item->getQuantity();
                endforeach;
                $totalmoney+=$total;
            }
        }
        echo "<div>Tổng số tiền đã nhận: $totalmoney</div>";
        echo "<div>Số lượng đơn hàng: $numoftrans</div>";
        echo "<div>Số lượng sản phẩm đã bán: $numofproduct</div>";
        echo "<table class="."table table-bordered".">";
            echo "<thead>
                <tr>
                    <th>ID</th>
                    <th>Ngày Mua</th>
                    <th>Tổng Số Tiền</th>
                    <th>Số Tiền Khách Đã Đưa</th>
                    <th>Tiền Thối</th>
                    <th>Số Lượng Sản Phẩm</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>";
            "<tbody>";
                foreach($transactions as $transaction):
                    $time = strtotime($transaction->getCreated()->format('Y-m-d'));
                    if($time>=$timestart&&$time<=$timeend){
                            echo"<tr>";
                                echo "<td>".$transaction->getId()."</td>";
                                echo "<td>".$transaction->getCreated()->format('d/m/Y H:i:s')."</td>";
                                $total = 0;
                                foreach ($transaction->getItems() as $item) : 
                                    $total += $item->getProduct()->getPrice() * $item->getQuantity() ;
                                endforeach;
                                echo "<td>".$total."</td>";
                                echo "<td>".$transaction->getGivenMoney()."</td>";

                                    $change = $transaction->getGivenMoney() - $total;

                                echo "<td>".$change."</td>";
                                    $totalquantity = 0;
                                    foreach ($transaction->getItems() as $item) : 
                                        $totalquantity += $item->getQuantity() ;
                                    endforeach;
                                echo "<td>".$totalquantity."</td>";
                                echo "<td>";
                                    echo '<button type="button" class="btn btn-primary getDetailBnt">Chi tiết</button>';
                                    
                                echo "</td>";
                            echo "</tr>";
                    }
                endforeach; 
                echo "</tbody>";
    }
    if(isset($_GET['timestart'])isset($_GET['timeend'])){