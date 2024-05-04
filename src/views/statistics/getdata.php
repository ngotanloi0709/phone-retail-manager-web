<?php

    function infor($totalmoney,$numoftrans,$numofproduct){
        echo '<div class="container">';
        echo '<div class="row">
            <div class="col">
                <div class="card bg-warning p-3 mb-2">
                    <div class="card-block">
                        <div class="row align-items-end">
                            <div >
                                <h4 class="text-white">'.$totalmoney.'</h4>
                                <h6 class="text-white ">Tổng số tiền đã nhận</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-danger p-3 mb-2">
                    <div class="card-block">
                        <div class="row align-items-end">
                            <div >
                                <h4 class="text-white">'.$numoftrans.'</h4>
                                <h6 class="text-white">Số lượng đơn hàng</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-success p-3 mb-2">
                    <div class="card-block">
                        <div class="row align-items-end">
                            <div >
                                <h4 class="text-white">'.$numofproduct.'</h4>
                                <h6 class="text-white">Số lượng sản phẩm đã bán</h6>
                            </div>  
                        </div>
                    </div>
                </div>
            </div> 
        </div>';  
        echo "</div>";                                     
    }
    function tablehead(){
        echo '<table class="table table-bordered ">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ngày Mua</th>
                    <th>Tổng Số Tiền</th>
                    <th>Số Tiền Khách Đã Đưa</th>
                    <th>Tiền Thối</th>
                    <th>Số Lượng Sản Phẩm</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>';
    }
    function tablebody($transaction){
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
    //theo moc thoi gian
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
        infor($totalmoney,$numoftrans,$numofproduct,);
        tablehead();
                foreach($transactions as $transaction):
                    $time = strtotime($transaction->getCreated()->format('Y-m-d'));
                    if($time>=$timestart&&$time<=$timeend){
                        tablebody($transaction);
                    }
                endforeach; 
                echo "</tbody>";
    }
    //theo loai thoi gian
    if( isset($_GET['timerange']) && ( isset($_GET['timeend'])==false || isset($_GET['timeend'])==false ) ){
        $timerange = $_GET['timerange'];
        $totalmoney=0;
        $numoftrans=0;
        $numofproduct=0;
        $timestart = 0;
        $timeend = 0;
        if($timerange == 'today'){
            $timestart = strtotime("today");
            $timeend = strtotime("tomorrow")-1;
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
            infor($totalmoney,$numoftrans,$numofproduct);
            tablehead();
                    foreach($transactions as $transaction):
                        $time = strtotime($transaction->getCreated()->format('Y-m-d'));
                        if($time>=$timestart&&$time<=$timeend){
                            tablebody($transaction);
                        }
                    endforeach; 
            echo "</tbody>";
        }
        if($timerange == 'yesterday'){
            $timestart = strtotime("yesterday");
            $timeend = strtotime("today")-1;
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
            infor($totalmoney,$numoftrans,$numofproduct);
            tablehead();
                    foreach($transactions as $transaction):
                        $time = strtotime($transaction->getCreated()->format('Y-m-d'));
                        if($time>=$timestart&&$time<=$timeend){
                            tablebody($transaction);
                        }
                    endforeach; 
            echo "</tbody>";
        }
        if($timerange == '7day'){
            $timestart = strtotime("-7 day");
            $timeend = strtotime("today")-1;
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
            infor($totalmoney,$numoftrans,$numofproduct);
            tablehead();
                    foreach($transactions as $transaction):
                        $time = strtotime($transaction->getCreated()->format('Y-m-d'));
                        if($time>=$timestart&&$time<=$timeend){
                            tablebody($transaction);
                        }
                    endforeach; 
            echo "</tbody>";
        }
        if($timerange == 'month'){
            $timestart = strtotime("first day of this month");
            $timeend = strtotime("last day of this month 23:59:59");
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
            infor($totalmoney,$numoftrans,$numofproduct);
            tablehead();
                    foreach($transactions as $transaction):
                        $time = strtotime($transaction->getCreated()->format('Y-m-d'));
                        if($time>=$timestart&&$time<=$timeend){
                            tablebody($transaction);
                        }
                    endforeach; 
            echo "</tbody>";
        }
    }
    
        
    